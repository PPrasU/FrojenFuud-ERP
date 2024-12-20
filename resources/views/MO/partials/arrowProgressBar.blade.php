<div class="wrapper-arrow">
    <div class="arrow-steps clearfix">
        <div class="step @if($state == 0) current @elseif($state > 0) done @endif">Draft</div>
        <div class="step @if($state == 1) current @elseif($state > 1) done @endif">Confirmed</div>
        <div class="step @if($state == 2) current @elseif($state > 2) done @endif">Check Availability</div>
        <div class="step @if($state == 3) current @elseif($state > 3) done @endif">In Progress</div>
        <div class="step @if($state == 4) current @elseif($state > 4) done @endif">Done</div>
    </div>
</div>
