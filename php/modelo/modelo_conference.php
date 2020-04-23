<?php

class modelo_conference
{

/* ----------------------------------------------------------------------------------- */
/* ---------------------------------- METODOS GET ------------------------------------ */
/* ----------------------------------------------------------------------------------- */
	
	//Devuelve turnos reservados	
	static function get_conference($where)
	{
        $datos = modelo_conference::consultar_db("conferences", '*', $where);	
        //casteo de timestamp a simpledate java
        if(count($datos)>0){        	
        	return $datos;
        }else{
        	return array();
        }        
	}
	static function insert($datos){						
		try {
			$sql = "INSERT INTO conferences(name,mail_owner,start_time,duration) VALUES (:name,:mail_owner,:start_time,:duration)";
	        $id = toba::db()->sentencia_preparar($sql);
	        toba::db()->sentencia_ejecutar($id, array('name'=>$datos['name'],
										        	'mail_owner'=>$datos['mail_owner'],
										        	'start_time'=>$datos['start_time'],
										        	'duration'=>$datos['duration']));
		} catch (toba_error_db $e) {
			error_log($e->get_mensaje_motor());
			return null;
		}
		$conference =  self::get_conference("name='{$datos['name']}'");        			
	    return $conference[0];
		
	}
	static function delete($id_conference){
		try {
			$sql = "DELETE FROM conferences WHERE id = :id_conference";
			$id = toba::db()->sentencia_preparar($sql);
			return toba::db()->sentencia_ejecutar($id, array('id_conference'=>$id_conference));
		} catch (toba_error_db $e) {
			error_log($e->get_mensaje_motor());
			return false;
		}
	}
	

	/* METODO GENERICO DB DASMI */
	static function consultar_db($tabla, $campos='*', $where=null, $order_by='', $limit=''){		
		$where = ($where) ? " WHERE $where" : "";
		$order_by = ($order_by == "") ? "" : "ORDER BY $order_by";

		$sql = "SELECT $campos FROM $tabla $where $order_by $limit";
		return toba::db()->consultar($sql);		
	}	
	
}


?>