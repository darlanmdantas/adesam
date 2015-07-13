### host do apache
<VirtualHost *:80>
	CustomLog "C:\Zend\Apache2\logs\base-sistema-access.log" common env=logme
	ServerName dev.base-sistema.com.br
	DocumentRoot "C:\Zend\Apache2\htdocs\walquirio\baseSistema\public"
		<Directory "C:\Zend\Apache2\htdocs\walquirio\baseSistema\public">
			DirectoryIndex index.php
			AllowOverride All
			Order allow,deny
			Allow from all
		</Directory>
</VirtualHost>

## no diretório data tem um arquivo etiquetagem.sql execute o arquivo com seu banco de dados mysql
Usuários: 
williamsaraiva@gmail.com
aliciacastrosaraiva@gmail.com
valquiriacastronogueira@gmail.com
visitante@gmail.com
Senhas: teste

Usuário: walquiriosaraiva@gmail.com
Senha: 123mudar


## neste exemplo tem um crud com usuário, perfil, usuário perfil e login de acesso

## execute o comando do composer para instalar as bibliotecas
## exemplo
com o gitbash aberto digite o seguinte comando
composer install

Caso tenha problema ou usa o cmd execute o comando abaixo
php composer.phar install

## altera o arquivo local.php e passe as configurações do seu banco postgres

## depois é só testar o sistema

##comando utilizados para gerar as entidades
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --namespace="Admin\Entity\\" --force  --from-database annotation ./module/Admin/src/
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:generate-entities ./module/Admin/src/ --generate-annotations=true

##para gerar entity especifica
php ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --filter='TbPerfil' --namespace="Admin\Entity\\" --force  --from-database annotation ./module/Admin/src/

##site de referencia para entender e ajustar relacionamentos das entidades
http://ormcheatsheet.com/
