
<?php 

require 'db_connect.php';

function getThemes()
{
    $ar = array();
    for($i = 1 ; $i <= 28 ; $i++)
    {
        $rd = file_get_contents('https://www.dw.com/ru/%D0%B2%D1%81%D0%B5-%D1%82%D0%B5%D0%BC%D1%8B-%D0%B2-%D0%B0%D0%BB%D1%84%D0%B0%D0%B2%D0%B8%D1%82%D0%BD%D0%BE%D0%BC-%D0%BF%D0%BE%D1%80%D1%8F%D0%B4%D0%BA%D0%B5/index-ru/' . $i);
        preg_match_all('~<div class="linkList plain">\s*<a href="\S*"><h2>(?<theme_name>.*)</h2></a>~i' , $rd , $ar);
        foreach($ar['theme_name'] as $v)
        {
            file_put_contents('themes.txt' , $v . ";" , FILE_APPEND);
            // var_dump("$v");
        }

        echo 'done' . '</br>';
    }
    
}

// getThemes();

function putFileDataIntoArray()
{
    global $pdo;
    $d = file_get_contents('themes.txt');
    // echo '<pre>';
    // print_r(explode(';' , $d));
    // echo '<pre>';

    $statement = $pdo->prepare("INSERT IGNORE INTO themes (theme_name) VALUES (?)");
    // $statement->execute(['$v']);
    $arr = explode(';' , $d);
    // foreach($arr as $v)
    // {
    //     $statement->execute([$v]);
    // }
    for($i = (int)((count($arr)/6)*6) ; $i < count($arr) ; $i++ )
    {
        print_r($statement->execute([$arr[$i]]));
    }
}

// putFileDataIntoArray();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <!-- ========= -->
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script> -->
    <script src="jquery/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="theia-sticky-sidebar-master/dist/ResizeSensor.js"></script>
    <script type="text/javascript" src="theia-sticky-sidebar-master/dist/theia-sticky-sidebar.js"></script>
    <script type="text/javascript" src="theia-sticky-sidebar-master/js/test.js"></script>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="theiaStickySidebar">
                porta. Iaculis urna id volutpat lacus laoreet non. Enim sed faucibus turpis in eu mi bibendum. Id consectetur purus ut faucibus pulvinar. Turpis in eu mi bibendum neque egestas congue. Sed lectus vestibulum mattis ullamcorper velit. Mauris nunc congue nisi vitae suscipit tellus mauris a. Vestibulum mattis ullamcorper velit sed. Lorem sed risus ultricies tristique nulla aliquet enim tortor at. Mauris augue neque gravida in fermentum et sollicitudin. Vitae elementum curabitur vitae nunc sed velit dignissim. Nulla pellentesque dignissim enim sit amet venenatis. Ac felis donec et odio pellentesque diam volutpat. At consectetur lorem donec massa. Donec ultrices tincidunt arcu non sodales neque. Bibendum arcu vitae elementum curabitur vitae nunc s ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare lectus sit amet est. Sagittis id consectetur purus ut. Suscipit tellus mauris a diam maecenas sed enim ut sem. Sem integer vitae justo eget magna fermentum iaculis eu non. Praesent elementum facilisis leo vel fringilla. In aliquam sem fringilla ut morbi tincidunt augue interdum. Orci porta non pulvinar neque. Felis imperdiet proin fermentum leo vel orci porta. Iaculis urna id volutpat lacus laoreet non. Enim sed faucibus turpis in eu mi bibendum. Id consectetur purus ut faucibus pulvinar. Turpis in eu mi bibendum neque egestas congue. Sed lectus vestibulum mattis ullamcorper velit. Mauris nunc congue nisi vitae suscipit tellus mauris a. Vestibulum mattis ullamcorper velit sed. Lorem sed risus ultricies tristique nulla aliquet enim tortor at. Mauris augue neque gravida in fermentum et sollicitudin. Vitae elementum curabitur vitae nunc sed velit dignissim. Nulla pellentesque dignissim enim sit amet venenatis. Ac felis donec et odio pellentesque diam volutpat. At consectetur lorem donec massa. Donec ultrices tincidunt arcu non sodales neque. Bibendum arcu vitae elementum curabitur vitae nunc s ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare lectus sit amet est. Sagittis id consectetur purus ut. Suscipit tellus mauris a diam maecenas sed enim ut sem. Sem integer vitae justo eget magna fermentum iaculis eu non. Praesent elementum facilisis leo vel fringilla. In aliquam sem fringilla ut morbi tincidunt augue interdum. Orci porta non pulvinar neque. Felis imperdiet proin fermentum leo vel orci porta. Iaculis urna id volutpat lacus laoreet non. Enim sed faucibus turpis in eu mi bibendum. Id consectetur purus ut faucibus pulvinar. Turpis in eu mi bibendum neque egestas congue. Sed lectus vestibulum mattis ullamcorper velit. Mauris nunc congue nisi vitae suscipit tellus mauris a. Vestibulum mattis ullamcorper velit sed. Lorem sed risus ultricies tristique nulla aliquet enim tortor at. Mauris augue neque gravida in fermentum et sollicitudin. Vitae elementum curabitur vitae nunc sed velit dignissim. Nulla pellentesque dignissim enim sit amet venenatis. Ac felis donec et odio pellentesque diam volutpat. At consectetur lorem donec massa. Donec ultrices tincidunt arcu non sodales neque. Bibendum arcu vitae elementum curabitur vitae nunc s ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare lectus sit amet est. Sagittis id consectetur purus ut. Suscipit tellus mauris a diam maecenas sed enim ut sem. Sem integer vitae justo eget magna fermentum iaculis eu non. Praesent elementum facilisis leo vel fringilla. In aliquam sem fringilla ut morbi tincidunt augue interdum. Orci porta non pulvinar neque. Felis imperdiet proin fermentum leo vel orci porta. Iaculis urna id volutpat lacus laoreet non. Enim sed faucibus turpis in eu mi bibendum. Id consectetur purus ut faucibus pulvinar. Turpis in eu mi bibendum neque egestas congue. Sed lectus vestibulum mattis ullamcorper velit. Mauris nunc congue nisi vitae suscipit tellus mauris a. Vestibulum mattis ullamcorper velit sed. Lorem sed risus ultricies tristique nulla aliquet enim tortor at. Mauris augue neque gravida in fermentum et sollicitudin. Vitae elementum curabitur vitae nunc sed velit dignissim. Nulla pellentesque dignissim enim sit amet venenatis. Ac felis donec et odio pellentesque diam volutpat. At consectetur lorem donec massa. Donec ultrices tincidunt arcu non sodales neque. Bibendum arcu vitae elementum curabitur vitae nunc s ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare lectus sit amet est. Sagittis id consectetur purus ut. Suscipit tellus mauris a diam maecenas sed enim ut sem. Sem integer vitae 
            </div>
        </div>
        <div class="sidebar">
            <div class="theiaStickySidebar">
                m ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Volutpat odio facilisis mauris sit amet. Risus pretium quam vulputate dignissim suspendisse. Feugiat pretium nibh ipsum consequat nisl. Blandit volutpat maecenas volutpat blandit aliquam. Iaculis eu non diam phasellus vestibulum lorem. Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa. Molestie nunc non blandit massa enim nec dui nunc mattis. Diam vel quam elementum pulvinar etiam non quam lacus. Urna porttitor rhoncus dolor purus non enim. Ullamcorper sit amet risus nullam eget felis eget. Nunc eget lorem dolor sed viverra ipsum nunc. Ultrices dui sapien eget mi proin sed. Sociis natoque penatibus et magnis dis parturient montes. Porta non pulvinar neque laoreet suspendisse interdum consectetur libero. Vitae elementum curabitur vitae nunc sed. Dolor morbi non arcu risus. Id velit ut tortor pretium viverra suspendisse. Vehicula ipsum a arcu cursus vitae congue. Ullamcorper dignissim cras tincidunt lobortis feugiat. Et leo duis ut diam. Augue mauris augue neque gravida in fermentum et sollicitudin. Cras sed felis eget velit aliquet sagittis id. Sed ullamcorper morbi tincidunt ornare. Cursus in hac habitasse platea dictumst quisque sagittis purus sit. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus. Nullam eget felis eget nunc lobortis. Volutpat maecenas volutpat blandit aliquam etiam erat. Netus et malesuada fames ac. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Adipiscing bibendum est ultricies integer quis auctor elit sed. Id venenatis a condimentum vitae. Rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant. Nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit. Et egestas quis ipsum suspendisse ultrices gravida dictum fusce. Suscipit adipiscing bibendum est ultricies. Blandit volutpat maecenas volutpat blandit aliquam etiam erat. Diam maecenas ultricies mi eget mauris. Integer vitae justo eget magna. Odio tempor orci dapibus ultrices in iaculis nunc sed. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Quam lacus suspendisse faucibus interdum posuere. Nisi est sit amet facilisis magna etiam. Id velit ut tortor pretium viverra. Risus nec feugiat in fermentum. Sed elementum tempus egestas sed sed risus pretium. Neque egestas congue quisque egestas diam in arcu. Ut eu sem integer vitae justo eget magna. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Mi quis hendrerit dolor magna eget est lorem ipsum. Sed vulputate mi sit amet mauris commodo quis imperdiet massa. Aliquet nibh praesent tristique magna sit amet purus gravida. Blandit cursus risus at ultrices mi tempus imperdiet  dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Volutpat odio facilisis mauris sit amet. Risus pretium quam vulputate dignissim suspendisse. Feugiat pretium nibh ipsum consequat nisl. Blandit volutpat maecenas volutpat blandit aliquam. Iaculis eu non diam phasellus vestibulum lorem. Placerat vestibulum lectus mauris ultrices eros in cursus turpis massa. Molestie nunc non blandit massa enim nec dui nunc mattis. Diam vel quam elementum pulvinar etiam non quam lacus. Urna porttitor rhoncus dolor purus non enim. Ullamcorper sit amet risus nullam eget felis eget. Nunc eget lorem dolor sed viverra ipsum nunc. Ultrices dui sapien eget mi proin sed. Sociis natoque penatibus et magnis dis parturient montes. Porta non pulvinar neque laoreet suspendisse interdum consectetur libero. Vitae elementum curabitur vitae nunc sed. Dolor morbi non arcu risus. Id velit ut tortor pretium viverra suspendisse. Vehicula ipsum a arcu cursus vitae congue. Ullamcorper dignissim cras tincidunt lobortis feugiat. Et leo duis ut diam. Augue mauris augue neque gravida in fermentum et sollicitudin. Cras sed felis eget velit aliquet sagittis id. Sed ullamcorper morbi tincidunt ornare. Cursus in hac habitasse platea dictumst quisque sagittis purus sit. Viverra suspendisse potenti nullam ac tortor vitae purus faucibus. Nullam eget felis eget nunc lobortis. Volutpat maecenas volutpat blandit aliquam etiam erat. Netus et malesuada fames ac. Tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Adipiscing bibendum est ultricies integer quis auctor elit sed. Id venenatis a condimentum vitae. Rhoncus aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant. Nunc mi ipsum faucibus vitae aliquet nec ullamcorper sit. Et egestas quis ipsum suspendisse ultrices gravida dictum fusce. Suscipit adipiscing bibendum est ultricies. Blandit volutpat maecenas volutpat blandit aliquam etiam erat. Diam maecenas ultricies mi eget mauris. Integer vitae justo eget magna. Odio tempor orci dapibus ultrices in iaculis nunc sed. Duis ultricies lacus sed turpis tincidunt id aliquet risus feugiat. Quam lacus suspendisse faucibus interdum posuere. Nisi est sit amet facilisis magna etiam. Id velit ut tortor pretium viverra. Risus nec feugiat in fermentum. Sed elementum tempus egestas sed sed risus pretium. Neque egestas congue quisque egestas diam in arcu. Ut eu sem integer vitae justo eget magna. Elementum pulvinar etiam non quam lacus suspendisse faucibus. Mi quis hendrerit dolor magna eget est lorem ipsum. Sed vulputate mi sit amet mauris commodo quis imperdiet massa. Aliquet nibh praesent tristique magna sit amet purus gravida. Blandit cursus risus at ultrices mi tempus imperdiet 
            </div>
        </div>
        <div class="sidebar">
            <div class="theiaStickySidebar">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare lectus sit amet est. Sagittis id consectetur purus ut. Suscipit tellus mauris a diam maecenas sed enim ut sem. Sem integer vitae justo eget magna fermentum iaculis eu non. Praesent elementum facilisis leo vel fringilla. In aliquam sem fringilla ut morbi tincidunt augue interdum. Orci porta non pulvinar neque. Felis imperdiet proin fermentum leo vel orci porta. Iaculis urna id volutpat lacus laoreet non. Enim sed faucibus turpis in eu mi bibendum. Id consectetur purus ut faucibus pulvinar. Turpis in eu mi bibendum neque egestas congue. Sed lectus vestibulum mattis ullamcorper velit. Mauris nunc congue nisi vitae suscipit tellus mauris a. Vestibulum mattis ullamcorper velit sed. Lorem sed risus ultricies tristique nulla aliquet enim tortor at. Mauris augue neque gravida in fermentum et sollicitudin. Vitae elementum curabitur vitae nunc sed velit dignissim. Nulla pellentesque dignissim enim sit amet venenatis. Ac felis donec et odio pellentesque diam volutpat. At consectetur lorem donec massa. Donec ultrices tincidunt arcu non sodales neque. Bibendum arcu vitae elementum curabitur vitae nunc ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Viverra ipsum nunc aliquet bibendum enim facilisis. Ipsum dolor sit amet consectetur adipiscing elit. Risus ultricies tristique nulla aliquet enim. Interdum varius sit amet mattis vulputate. Pretium vulputate sapien nec sagittis aliquam malesuada bibendum arcu. Adipiscing elit pellentesque habitant morbi. Eu augue ut lectus arcu bibendum at varius. Morbi non arcu risus quis varius quam quisque id. Egestas egestas fringilla phasellus faucibus. Imperdiet proin fermentum leo vel orci porta non pulvinar. Ut consequat semper viverra nam libero justo. Semper feugiat nibh sed pulvinar proin gravida hendrerit lectus. Non curabitur gravida arcu ac tortor dignissim convallis aenean et. Mattis enim ut tellus elementum sagittis vitae et leo duis. Ornare 
            </div>
        </div>
    </div>
</body>
</html>
<style>
    div.container {
        display: flex;
        /* flex-direction: row ; */
        border: 1px solid red ; 
    }

    div.sidebar {
        width: 20%;
        /* float: left; */
    }
</style>
<script type="text/javascript">
    jQuery('.sidebar').theiaStickySidebar({
        
    });
    
</script>
