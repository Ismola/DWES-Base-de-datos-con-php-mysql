# DWES-Unidad-3

![Screenshot 2022-02-24 at 19-52-59 Screenshot](https://user-images.githubusercontent.com/60386407/155588746-52f8375d-a54f-4621-bba2-fc3c01ec9d16.png)


## Trabajo final de la unidad 3
### Requisitos para que el proyecto funcione:
Se necesitará acceso a internet para que el enlace a boostrap se cargue.

La base de datos con la que se trabaja es escuela. Contiene 2 tablas:
#### Alumnos
id - nombre - apellidos - dni - fechaNacimiento - idTipoVia - nombreVia - numeroVia - localidad - telefono
#### Usuarios
id - usuario - contraseña - fecha_alt - permisos - true

Esta ultima tabla contiene un usuario llamado root, de contraseña root
### Que encontrarás
Desde esta base de datos, se puede crear usuarios (siempre que no existan ya)
Iniciar sesion (siempre que pongas bien la contraseña y el usuario)
Entrar a la base de datos.
#### Si no tienes permisos podrás:
Hacer una consulta a la base de datos mediante un formulario para ver lo usuarios

#### Si tienes permisos podrás:
Además de lo anterior, podrás introducir alumnos. Para rellenaras un formulario.
Editar los alumnos existentes. Para ello podrás hacer una consulta a la base de datos que generará una tabla editable con los alumnos buscados
Eliminar alumnos. Para ello tendrás que hacer una consulta a la base de datos que generará una tabla con un chekbox para cada usuario
Ver y modificar los a los usuarios. Para ello tendrás que hacer una consulta a la base de datos, que generará una tabla editable. Útil para darle permisos a los usuario, ya que al principio solo root tiene permisos. Tambiém permitirá cambiar el tema, teniendo 4 para elegir. Al cambiar el tema se cambiará el fondo y los colores que se usan de acento.
