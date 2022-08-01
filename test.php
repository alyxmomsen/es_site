
<?php

function contentGenerator($number)
{
    $result = '';

    for($index = 0 ; $index < $number ; $index++)
    {
        $result .= "
            Semper risus in hendrerit gravida. 
            Id leo in vitae turpis massa sed elementum tempus. 
            In pellentesque massa placerat duis ultricies lacus. 
            Accumsan tortor posuere ac ut consequat semper. 
            Semper quis lectus nulla at. Mi ipsum faucibus vitae aliquet. 
            Cras adipiscing enim eu turpis. 
            Ornare aenean euismod elementum nisi quis. 
            Phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor. 
            Dignissim enim sit amet venenatis urna cursus eget. 
            Vulputate ut pharetra sit amet.<br><br>
        ";
    }   
    
    return $result;
}

?>

<!DOCTYPE html>
<div>
    <h1>
        header
    </h1>
    <p>
        body
    </p>
    <div class="flex-container">
        <div class="content flex-item">
            <div>
                <?= contentGenerator(2) ?>
            </div>
        </div>
        <div class="content flex-item">
            <div class="theiaStickySidebar">
                <?= contentGenerator(1) ?>
            </div>
        </div>
        <div class="content flex-item">
            <div class="theiaStickySidebar">
                <?= contentGenerator(9) ?>
            </div>
        </div>
        <div class="content flex-item">
            <div class="theiaStickySidebar">
                <?= contentGenerator(6) ?>
            </div>
        </div>
        <div class="content flex-item">
            <div class="theiaStickySidebar">
                <?= contentGenerator(4) ?>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet/less" type="text/css" href="less&css/main.less" />
<script src="less&css/less.js"></script>
<script src="less&css/theia-sticky-sidebar.js"></script>
<script src="less&css/ResizeSensor.js"></script>
<style>
    div.flex-container {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
    }

    div.flex-item {
        font-size: 1.2em;
        width:  20%;
    }
</style>
<script>
    jQuery(document).ready(function() {
        jQuery('.content, .sidebar').theiaStickySidebar({
            // Настройки
            additionalMarginTop: 30
        });
    });
</script>