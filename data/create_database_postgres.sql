/*PRIMEIRO PASSO - INICIO*/
/* com o usuário postgres logado executar o script abaixo, execute cada comando por vez */
/*criando usuário para o banco de dados*/
CREATE USER etiquetagem WITH PASSWORD '123mudar';

/*criando o database*/
CREATE DATABASE etiquetagem
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       CONNECTION LIMIT = -1;	   

/*concedendo permissão para o banco criado para os usuários: postgres e etiquetagem*/
GRANT ALL ON DATABASE etiquetagem TO postgres;
GRANT ALL ON DATABASE etiquetagem TO etiquetagem;
/*FIM*/

/*SEGUNDO PASSO - INICIO*/
/*com o usuario postgres logado e setado no database etiquetagem execute o script abaixo*/
/*criando esquema do banco de dados criado*/
CREATE SCHEMA etiquetagem
  AUTHORIZATION postgres;

/*concedendo permissão para o esquema criado para os usuários: postgres e etiquetagem*/
GRANT ALL ON SCHEMA etiquetagem TO postgres;
GRANT ALL ON SCHEMA etiquetagem TO etiquetagem;
COMMENT ON SCHEMA etiquetagem
  IS 'esquema do sistema etiquetagem';
/*FIM*/

/*TERCEITO PASSO - INICIO*/
--Executar o arquivo script.sql que está no diretorio de Documentacao/MER
--Executar o arquivo primeiro_insert_etiquetagem.sql
--Testar o acesso ao sistema com o usuário:
--Usuário: 00352293306
--Senha: 123mudar
/*FIM*/