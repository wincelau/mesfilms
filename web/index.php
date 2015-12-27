<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Mes films</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
		$rootDir=dirname(__FILE__)."/..";
		$config = json_decode(file_get_content($rootDir."/config/config.json"));
                $dirname = $config->db_dir."/files";
                $dirnameinfos = $config->db_dir."/infos";
                $dirnameimg = $config->db_dir."/img";
                $dir = opendir($dirname); 

                while($file = readdir($dir)) {
                    if($file == '.' || $file == '..' || is_dir($dirname.$file))
                    {
                        continue;
                    }

                    $infos = new stdClass();
                    $infos->original_title = $file;
                    $infos->pitch = "";
                    $infos->thumbnail_url = "";
                    $infos->release_date = null;

                    if(is_file($dirnameinfos."/".$file)) {
                        $infos = json_decode(file_get_contents($dirnameinfos."/".$file));
                    }

                    if(!isset($infos)) {

                        continue;
                    }

                    if($infos->poster_path && !is_file($dirnameimg."/".$file)) {
                        $imgContent = file_get_contents("https://image.tmdb.org/t/p/w396/".$infos->poster_path);
                        if($imgContent) {
                            file_put_contents($dirnameimg."/".$file, $imgContent);
                        }
                    }
                    $imagebase64=null;
                    if(is_file($dirnameimg."/".$file)) {
                        $imagebase64 = base64_encode((file_get_contents($dirnameimg."/".$file)));
                    }

                    $infos->note = $infos->vote_average;

                ?>
                <div class="col-xs-12" style="height: 270px;margin-top: 5px;">
                    <div class="media">
                        <div class="media-left">
                            <a href="#"><img class="media-object" style="height: 270px; width: 180px;" alt="<?php echo $infos->title ?>" src="data:image/jpg;base64,<?php echo $imagebase64 ?>" /></a>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">
                            <?php echo $infos->title ?>
                            <small><?php echo date('Y', strtotime($infos->release_date)) ?></small>
                            <span class="pull-right"><span class="label <?php if($infos->note >= 7): ?>label-success<?php elseif($infos->note >= 5): ?>label-warning<?php else: ?>label-danger<?php endif; ?> pull-right"><?php echo $infos->note ?></span></span>
                            </h3>
                            <p style="height: 236px; overflow: hidden; overflow-y: auto;"><?php echo $infos->overview ?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
                closedir($dir);
                ?>
            </div>
        </div>
    </body>
</html>
