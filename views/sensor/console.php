<?php

use yii\web\View;

//in
//  power_on
//  check_access
//  events
//  ping
//
//out
//  set_active
//  open_door
//  set_mode
//  set_timezone
//  set_door_params
//  add_cards
//  del_cards
//  clear_cards
$this->registerCss('
    .output{
        background: black;
        color: yellow;
        padding: 1em;
        height: 200px;
        overflow-y: scroll;
    }
');

$this->registerJs('
    $(window).ready(function(){
        setInterval(function(){
            $(".output").prepend("<div class=output_item>"+Date.now()+"</div>");
        },2000);
    });
', View::POS_END, 'scud_console');

?>

<h1>Scud console</h1>
<hr>
<div class="row">
    <div class="col-md-8">
        <div class="output"></div>
    </div>
    <div class="col-md-4">
        <div>
            <button>Включить активный режим</button>
        </div>
        <div>
            <button>Открыть дверь</button>
        </div>
        <div>
            <select>
                <option>--- Выберите ---</option>
                <option value="0">норма</option>
                <option value="1">блок</option>
                <option value="2">свободный проход</option>
                <option value="3">ожидание свободного прохода</option>
            </select>
            <button>Указать режим</button>
        </div>
        <div>
            <button>Добавить карту</button>
        </div>
        <div>
            <button>Удалить карту</button>
        </div>
    </div>
</div>
