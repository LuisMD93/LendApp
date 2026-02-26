<?php

namespace Shared\Helpers\Constants;

class Constans {
    // Respuestas
    const RESPONSE_SUCCESS = 'success';
    const RESPONSE_ERROR = 'error';
    const RESPONSE_RESULT  = 'response';
    const ERROR_MESSAGE = 'Ruta no encontrada';
    const ERROR_MESSAGE_SERVER = 'Error interno del servidor, Intente nuevamente';
    const ERROR_MESSAGE_ACCESS = 'Forbidden 🔒. You do not have access to this route .';
    CONST WARNING_MESSAGE = 'Método no permitido';
    CONST UNAUTHORIZED_MESSAGE = 'Unauthorized!!, You do not have access to this route';
    CONST DELETE_MESSAGE = '❌ Deleted data';
    CONST DELETE_EMOJI = ' ❌ ' ;
    CONST ERROR_MESSAGE_TOKEN = ' ❌ Invalid token 👊🏾';
    
    /*
        $mensaje = '⏰ Token expirado ⚠️';        // reloj + advertencia
        $mensaje = '🔒 Token expirado ❗';        // candado + signo de exclamación
        $mensaje = '💀 Token expirado ☠️';       // calavera, para algo dramático
        $mensaje = '🛑 Token expirado ❌';        // stop + cruz
        $mensaje = '⚡ Token expirado ⚡';        // rayos, para urgencia
    */
    
    // Otras constantes globales
    const API_VERSION = '1.0';
    const DEFAULT_TIMEZONE = 'UTC';

    const FIELDS = ["username","email","password","api_token","phone","rol_user"];
    const REPORT_FIELDS =["location","name","amount" ,"description","lendStatus","id_user"];   

    const REQUEST_MAPPING = 'ApiHexagonalPhp/public/learn';
    
}
