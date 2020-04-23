CREATE TABLE public.conferences
(
  id serial NOT NULL,
  name character varying(1024) NOT NULL,
  mail_owner character varying(1024) NOT NULL,
  start_time timestamp with time zone,
  duration integer,
  CONSTRAINT pk_conferences PRIMARY KEY (id)
);
