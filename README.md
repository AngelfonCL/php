# Angelfon PHP SDK

Con el SDK PHP de Angelfon puedes generar llamadas telefónicas fácilmente, en pocos pasos.

## Instalación

Puedes instalar **angelfon-php** usando composer o directamente desde el repositorio.

#### Usando Composer:

**angelfon-php** está disponible en Packagist como
[`angelfon/sdk`](http://packagist.org/packages/angelfon/sdk).

#### Configuración

Debes tener una [cuenta Angelfon][afid] para usar esta librería.
Solicita tus credenciales de cliente escribiéndonos a fernando@angelfon.com

Te recomendamos definir en tu entorno las variables asociadas a tu cuenta:

```
ANGELFON_USERNAME=your@email.com
ANGELFON_PASSWORD=mypass
ANGELFON_CLIENT_ID=404
ANGELFON_CLIENT_SECRET=u8R3ZVmesIbpaEx3F3nupP4D3SSJ9N3QSQSBYuoX
```

De esta forma puedes instanciar el cliente Rest sin argumentos

```php
$client = new Angelfon\SDK\Rest\Client();
```

## Guía rápida

### Enviar un SMS

```php
// Envía un SMS usando Angelfon REST API y PHP
<?php

$client = new Angelfon\SDK\Rest\Client();
$sms = $client->sms->create(
  '912345678', // Envía el SMS a éste número
  array(
    'body' => 'Hola que tal!'
  )
);

print $sms->id;
```

### Realizar una Llamada

```php
<?php

$client = new Angelfon\SDK\Rest\Client();

// Envía un audio almacenado en tu cuenta Angelfon
$call = $client->calls->create(
  '912345678', // Destinatario
  array(
      'type' => 1, //Llamada unidireccional que requiere 'audioId1'
      'recipientName' => 'Destinatario de ejemplo',
      'audioId1' => 123
  )
);

print $call->id;
```

También puedes enviar la llamada a más de un destinatario

```php
<?php

$client = new Angelfon\SDK\Rest\Client();

// Envía un texto como llamada
$call = $client->calls->create(
  array(
    'destinatario 1' => '912345678',
    'destinatario 2' => '987654321',
  ),
  array(
    'type' => 6, //Llamada unidireccional que requiere 'tts1'
    'tts1' => 'Esta llamada es un texto hablado'
  ) 
);

print $call->batchId;
```

## Documentación

La documentación de la API REST Angelfon la puedes encontrar [aquí][apidocs].

La documentación de este SDK la puedes encontrar [aquí][documentation].


## Prerequisitos

* PHP >= 5.3
* The PHP JSON extension

# Soporte

Si necesitas ayuda instalando o usando esta librería, [ponte en contacto con nosotros!][contact]


[apidocs]: https://api.angelfon.com/0.99/documentation
[contact]: http://www.angelfon.com/contact.html
[documentation]: https://angelfon.github.io/angelfon-php/
[afid]: https://angelfonid.angelfon.com/home/registro
