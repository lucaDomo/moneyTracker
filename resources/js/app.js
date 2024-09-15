import './bootstrap';
import 'bootstrap';

import Alpine from 'alpinejs';
import {
    format,
    add,
    eachDayOfInterval,
    startOfWeek,
    startOfMonth,
    endOfWeek,
    endOfMonth,
    isSameMonth,
    isSameDay
    
} from "https://cdn.skypack.dev/date-fns@2.29.3"

window.Alpine = Alpine;

Alpine.start();