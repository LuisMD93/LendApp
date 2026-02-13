<?php

namespace Shared\Helpers\Enums;


enum TypeTimeEnum: string {
    case DAYS = 'Días';
    case HOURS = 'Horas';
    case MONTHS = 'Meses';
    case YEARS = 'Años';
    case UNDEFINED = 'Undefined'; 
}