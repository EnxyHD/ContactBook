<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact Book</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gowun+Dodum&display=swap" rel="stylesheet"> 
        
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="menubar">
                <h1>My Contact Book</h1>
            
                <div class="name">
                    <?php
                        if(isset($_GET['firstName'])){
                            echo $_GET['firstName']." ". $_GET['secoundName'];
                        }
                        else{
                            echo '<a href="index.php?page=login">Anmelden</a>';
                        }
                    ?>
                    <div class="avatar">
                    <?php
                        if(isset($_GET['firstName'])){
                            echo $_GET['firstName'][0]. $_GET['secoundName'][0];
                        }
                    ?>
                    </div> 
                </div>
            </div>
        </header>
        <div class="main">
            <div class="menu">
                <a href="index.php?page=start"><img src="img/home.png">Start</a>
                <a href="index.php?page=contacts"><img src="img/contacts.png">Kontakte</a>
                <a href="index.php?page=add"><img src="img/add.png">Kontakt hinzufügen</a>
                <a href="index.php?page=legal"><img src="img/legal.png">Impressum</a>
            </div>
            <div class="content">
                <?php 
                    $contacts = [];

                    if (file_exists('contacts.txt')){
                        $text = file_get_contents('contacts.txt', true);
                        $contacts = json_decode($text, true);
                    }

                    if (isset($_POST['name']) && isset($_POST['phone'])){
                        echo 'Kontakt <b>'.$_POST['name'].'</b> wurde mit der Nummer <b>'.$_POST['phone'].'</b> hinzugefügt.';
                        $newContact = [
                            'name' => $_POST['name'],
                            'phone' => $_POST['phone'],
                        ];
                        array_push($contacts, $newContact);
                        file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
                    }

                    if(!empty($_GET['page'])){
                        $page = $_GET['page'];
                    }
                    else{
                        $page = 'start';
                    }


                    if ($page == 'contacts'){
                        $headline = 'Deine Kontakte';
                    }
                    else if($page == 'legal'){
                        $headline = 'Das Impressum';
                    }
                    else if($page == 'add'){
                        $headline = 'Kontakt hinzufügen';
                    }
                    else if($page == 'login'){
                        $headline = 'Anmeldung';
                    }
                    else{
                        $headline = 'Herzlich wilkommen';
                    }

                    echo '<h1>' . $headline . '</h1>';

                    switch ($page) {
                        case 'contacts':
                            echo "
                                <h3>Hier findest du all deine gespeicherten Kontakte</h3>
                            ";
                            foreach ($contacts as $row){
                                $name = $row['name'];
                                $phone = $row['phone'];
                                echo "
                                    <div class = 'card'>
                                        <img class='profilePicture' src='img/profilePicture.png'>
                                        <b>$name</b> <br/>
                                        $phone

                                        <a class='phoneButton' href='tel:$phone'>Anrufen</a>
                                    </div>
                                ";
                            }

                            break;
                        case 'add':
                                echo "
                                <h3>Auf dieser Seite kannst du Kontakte hinzufügen.<h3>
                                
                                <form action='?page=contacts' method='POST'>
                                    <div><input placeholder='Namen eingeben' name='name'></div>
                                    <div><input placeholder='Telefonnummer eingeben' name='phone'></div>
                                    <div><button tybe='submit'>Absenden</button></div>
                                </form>
                                ";
                                break;
                        case 'legal':
                            echo "Das ist das Impressum!";
                            break;
                        case 'login':
                            echo "
                                <form method='GET'>
                                    <div><input placeholder='Namen eingeben' name='firstName'></div>
                                    <div><input placeholder='Nachname eingeben' name='secoundName'></div>
                                    <div><br><button tybe='submit'>Anmelden</button></div>
                                </form>
                            ";
                            break;    
                        default:
                            echo "
                                Hier findest du nix :)
                            ";
                    }
                ?>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>
</html>