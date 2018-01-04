# Angelfon PHP SDK

Con el SDK PHP de Angelfon puedes generar llamadas telefónicas fácilmente, en pocos pasos.

## Instalación

Puedes instalar **angelfon-php** usando composer o directamente desde el repositorio.
You can install **twilio-php** via composer or by downloading the source.

#### Usando Composer:

**angelfon-php** está disponible en Packagist como
[`angelfon/sdk`](http://packagist.org/packages/angelfon/sdk).

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
```

## Documentación

La documentación de la API REST Angelfon la puedes encontrar [aquí][apidocs].

The PHP library documentation can be found [here][documentation].


## Prerequisitos

* PHP >= 5.3
* The PHP JSON extension

# Soporte

Si necesitas ayuda instalando o usando esta librería, [ponte en contacto con nosotros!][contact]


[apidocs]: https://api.angelfon.com/0.99/documentation
[contact]: https://www.angelfon.com/contact.html
[documentation]: https://angelfon.github.io/angelfon-php/
