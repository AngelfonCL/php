# Angelfon PHP SDK

[![Packagist](https://img.shields.io/packagist/v/angelfon/sdk.svg)](https://packagist.org/packages/angelfon/sdk)
[![Packagist](https://img.shields.io/packagist/dt/angelfon/sdk.svg)](https://packagist.org/packages/angelfon/sdk)

Con el SDK PHP de Angelfon puedes generar llamadas telefónicas fácilmente, en pocos pasos.

## Instalación

Puedes instalar **angelfon-php** usando composer o directamente desde el repositorio.

#### Usando Composer:

**angelfon-php** está disponible en Packagist como
[`angelfon/sdk`](http://packagist.org/packages/angelfon/sdk).

```
composer require angelfon/sdk
```

#### Configuración

Debes tener una [cuenta Angelfon][afid] para usar esta librería.
Puedes grabar y revisar tus audios en [Angelfon Plus][afplus], e indicar el ID del audio que desees en tu llamada.

Solicita tus credenciales de cliente escribiéndonos a <fernando@angelfon.com>

Te recomendamos agregar las variables asociadas a tu cuenta en el entorno de tu aplicación:

```
ANGELFON_USERNAME=your@email.com
ANGELFON_PASSWORD=mypass
ANGELFON_CLIENT_ID=404
ANGELFON_CLIENT_SECRET=u8R3ZVmesIbpaEx3F3nupP4D3SSJ9N3QSQSBYuoX
```

De esta forma no es necesario indicar tus credenciales al instanciar el cliente Rest

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

También puedes enviar la llamada a más de un destinatario a la vez

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

Puedes hacer uso de los métodos de ayuda para la creación de las opciones

```php
<?php

use Angelfon\SDK\Rest\Client;
use Angelfon\SDK\Rest\Api\V099\User\CallOptions;

$client = new Client();

// Genera opciones de la llamada
$options = CallOptions::createWithSingleTts('Esta otra llamada también es un texto hablado');

// $options = CallOptions::createFree(123);
// $options = CallOptions::createWithSingleAudio(123);
// $options = CallOptions::createWithAnswer(123);
// $options = CallOptions::createWithAudioAndTts(123, 'primer tts', 124, 'segundo tts', 125);

// Especifica la hora a la cual realizar la llamada
$options->setCallAt('2018-07-27 18:00:00');

// Usa Caller ID para mostrar tu número registrado en Angelfon al realizar la llamada
$options->setCallerId(true);

// Envía la llamada
$calls = $client->calls->create(
  array(
    'destinatario 1' => '912345678',
    'destinatario 2' => '987654321',
  ),
  $options
);

print $calls->batchId;
```

Mas información de los métodos de ayuda para llamadas los puedes encontrar [aquí][calltypes].

### Obtener Llamadas

```php
<?php

$client = new Angelfon\SDK\Rest\Client();

// Genera opciones de lectura de la llamada
$options = CallOptions::read();

$options->setRecipient('912345678'); // Mostrar solo llamadas realizadas a este número
$options->setBatchId('ff9891b45733305b275026ba4218eaf2ed988837750298131a0551d7723acffd1d5cb656825db85668c9d2658b21d4d03fb54d12fc35f3c8ff3e616a92998e23'); // Mostrar sólo llamadas en este Batch

$calls = $this->client->calls->read($options);

print $calls[0]->id;
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
[documentation]: https://angelfoncl.github.io/php
[calltypes]: https://angelfoncl.github.io/php/class-Angelfon.SDK.Rest.Api.V099.User.CallOptions.html#_createFree
[afid]: https://angelfonid.angelfon.com/home/registro
[afplus]: https://plus.angelfon.com/mensajes
