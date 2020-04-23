<?php
require_once("modelo/modelo_conference.php");

use SIUToba\rest\rest;


use SIUToba\rest\lib\rest_hidratador;
use SIUToba\rest\lib\rest_validador;
use SIUToba\rest\lib\rest_filtro_sql;

class recurso_conference implements SIUToba\rest\lib\modelable
{

    public static function _get_modelos() {
        return array(
                // "Mostrar"
                //Formato para mostrar el conferencia
                'Conference'=>array(
                	'id'=> array('_validar' => array(rest_validador::TIPO_INT)),
					'name'=>array('_validar' => array(rest_validador::TIPO_TEXTO)),
					'mail_owner'=>array('_validar' => array(rest_validador::TIPO_TEXTO)),
					'start_time'=>array('_validar' => array(rest_validador::TIPO_TEXTO)),
					'duration'=> array('_validar' => array(rest_validador::TIPO_INT))                                    
                )
        );
    }

/* ----------------------------------------------------------------------------------- */
/* ---------------------------------- METODOS GET ------------------------------------ */
/* ----------------------------------------------------------------------------------- */

    /*
    * Se consume en GET /conference/{id_conference}
    * @summary Retorna datos de una conferencia.
    
    * @param_query $id_conference integer identificador de la conferencia
    * @responses 404 No existe el turno
    * @responses 400 Error en los parámetros
    */
    function get($id_conference)
    {                
        
        $modelos = self::_get_modelos();
        //
        if(!is_numeric($id_conference)){
            rest::response()->error_negocio(array('message'=>'id must be integer'),400);
        }else{
            $resultado = modelo_conference::get_conference("id=$id_conference");
            if($resultado){
                $resultado[0]['start_time'] = $this->timestampToSimpleDate($resultado[0]['start_time']);
                $resultado = rest_hidratador::hidratar($modelos['Conference'], $resultado);                        
                rest::response()->get($resultado[0]);    
            }else{
                rest::response()->not_found();    
            }
            
        }                
    }
    /*
    * Se consume en POST /conference/
    * @summary Creacion de la sala.

    * @param_body name string short name of the conference room(not full MUC address).
    * @param_body start_time string conference start date and time
    * @param_body mail_owner string if authentication system is enabled this field will contain user's identity. It that case it will not be possible to create new conference room without authenticating.

    * @responses 200 Conference created successfully
    * @responses 201 Conference created successfully
    * @responses 409 Conference already exists
    */
    function post_list()
    {        
        $string = rest::request()->get_body();
        if($this->parametros_post_validos($string)){
            $datos = $this->parse_body_post($string);            

            //si existe la sala
            $conference = modelo_conference::get_conference("name='{$datos['name']}'");
            if(count($conference)>0){                        
                rest::response()->error_negocio(array('conflic_id'=>$conference[0]['id']),409);
            }else{
            //creacion de la sala                            
                $new_conference = modelo_conference::insert($datos);   
                
                if($new_conference)
                    rest::response()->post($new_conference);
                else
                  rest::response()->error_negocio(array('message'=>'No se pudo generar la conferencia'),403);  
            }        
        }else{
            rest::response()->error_negocio(array('message'=>'error en los parametros'),400);
        }
    }

    function parametros_post_validos($query_string){
        $obligatorios = array('name','mail_owner','start_time');
        foreach ($obligatorios as $key => $campo) {            
           if(strpos($query_string, $campo)===false){
                return false;
           } 
        }
        return true;
    }    
    function parse_body_post($query_string){
        $query_string = str_replace("%40","@",$query_string);
        $query_string = str_replace("%3A",":",$query_string);        
        parse_str($query_string); //hace el explode

        //if(!isset($duration))
            $duration = toba::proyecto()->get_parametro('jitsi','duracion_sala');

        return array('name' => $name,
                    'mail_owner' => $mail_owner,
                    'start_time' => $this->SimpleDateTotimestamp($start_time),
                    'duration' => $duration);
    }

    /*
    * Se consume en DELETE /conference/{id_conference}
    * @summary Eliminar sala.

    * @param_query name string short name of the conference room(not full MUC address).
    
    * @responses 200 Conference created successfully
    * @responses 201 Conference created successfully
    * @responses 409 Conference already exists
    */
    function delete($id_conference)
    {    
        $ok = modelo_conference::delete($id_conference);
        $errores = array();
        if (!$ok) {
            rest::response()->not_found();
        } else {
            rest::response()->delete($errores);
        }
    }

    //cambia la fecha de timestamp a SimpleDate
    function timestampToSimpleDate($timestamp){
        return date('Y-m-d\TH:i:s.uZ' ,strtotime($timestamp));
    }
    function SimpleDateTotimestamp($simple_date){
        return date('Y-m-d H:i:s' ,strtotime($simple_date));
    }
}

?>
