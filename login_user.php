<?php
//login_admin.php
session_start();

// include the database class
include "database.php";

// $title contains the title for the page
$title = "User Page";


// start a new db connection
$db = new DB('localhost', 'root', '', 'project1', 'utf8');

// if the $_SESSION["email"] variable is not set then return the user to the index page
if(!isset($_SESSION["email"])) {
    header("location:index.php"); 
}

// check the user role
if(isset($_SESSION["email"])){
    $role = $db->checkRole();
}

// this inserts the header and the navbar
require_once('header.php');  

// rowcounter set at 1 for the excel export
$rowcounter = 1;

?>

<body>
    <br>
    <div class="container">
        <table id="tableexport" class="table table-responsive table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>id</th>
                    <th>Voornaam</th>
                    <th>Tussenvoegsel</th>
                    <th>Achternaam</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- for each person echo tablerows with table descriptions and edit/delete buttons, $rowcounter +1 for each table row !-->
                <?php if($db->getPerson()) : ?>
                    <?php foreach($db->getPerson() as $person) : ?>
                        <tr>
                            <td><?= $person['id'] ?></td>
                            <td><?= $person['voornaam'] ?></td>
                            <td><?= $person['tussenvoegsel'] ?></td>
                            <td><?= $person['achternaam'] ?></td>
                            <td><?= $person['email'] ?></td>
                            <td><?= $person['password'] ?></td>
                            <td><a href="edit_user.php?id=<?= $person['id'] ?>" class="btn btn-warning">Edit</a></td>
                            <td><a href="user.process.php?id=<?= $person['id'] ?>&send=del" class="btn btn-danger">Delete</a></td>
                            <?php $rowcounter++;?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p class="mx-auto mt-5">There are no users to be shown.</p>
                <?php endif; ?>
            </tbody>
        </table>

        <button style="margin:0 auto; display:block;" data-fileblob="{&quot;data&quot;:&quot;\&quot;id\&quot;,\&quot;Voornaam\&quot;,\&quot;Tussenvoegsel\&quot;,\&quot;Achternaam\&quot;,\&quot;Email\&quot;,\&quot;Password\&quot;,\&quot;\&quot;,\&quot;\&quot;\r\n\&quot;11\&quot;,\&quot;wessel\&quot;,\&quot;test\&quot;,\&quot;test\&quot;,\&quot;test@fake.com\&quot;,\&quot;$2y$10$BPkVDl6Dw.QqjRx/j7mbFO1ed1tCvDXsZ2aktVE934lCkKyOwFsvO\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;12\&quot;,\&quot;admin\&quot;,\&quot;admin\&quot;,\&quot;admin\&quot;,\&quot;Admin@123.nl\&quot;,\&quot;$2y$10$yJa/VC2beT7FmyFiT.afDuHcCYmqARhsV2UJ/QCY89ZfgdQQZFM0q\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;15\&quot;,\&quot;rocco\&quot;,\&quot;van\&quot;,\&quot;baardwijk\&quot;,\&quot;rocco1999@hotmail.nl\&quot;,\&quot;$2y$10$FT6jFAnkK0IFJLxiq5sXbuzUEPFYt9DpbXExXldPNVxPKVjVKrGXa\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;19\&quot;,\&quot;rocco\&quot;,\&quot;van\&quot;,\&quot;Baardwijk\&quot;,\&quot;r.rocco@hotmail.com\&quot;,\&quot;$2y$10$Q5TYLZBAvzOznD8PtieGQuzn2WDNeH4rd2y2eZOVXl3aOC4bnxgm6\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;28\&quot;,\&quot;test5\&quot;,\&quot;test5\&quot;,\&quot;test5\&quot;,\&quot;test5@email.com\&quot;,\&quot;$2y$10$dy9a/bn3soG7zh/gXSZ1Xu8Wtvvic6PeW.qek3pJS4BuwJk33vDAO\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;30\&quot;,\&quot;test6\&quot;,\&quot;test6\&quot;,\&quot;test6\&quot;,\&quot;test@hotmail.com\&quot;,\&quot;$2y$10$dNMfVNkDjH3hnULYm0um8OfcXqsk6M9xA2MwRXNR5HvrtHJLAa6MS\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;\r\n\&quot;31\&quot;,\&quot;test8\&quot;,\&quot;test8\&quot;,\&quot;test8\&quot;,\&quot;test8@fake.nl\&quot;,\&quot;$2y$10$MzYQdHQollHwU99/ptmouuhZAQnB6TWxNG4G9Y7VjoeKMd9/./upu\&quot;,\&quot;Edit\&quot;,\&quot;Delete\&quot;&quot;,&quot;fileName&quot;:&quot;tableexport&quot;,&quot;mimeType&quot;:&quot;text/csv&quot;,&quot;fileExtension&quot;:&quot;.csv&quot;}" class="btn btn-default csv">Export to csv</button>
    </div>
    
    <!-- current date and time !-->
    <div style="position: fixed; bottom: 0; left: 0;">  
        <?= date("Y-m-d H:i:s",time())?>
    </div>
    
    <br>
    
    <!-- insert script files needed for excel export!-->
    <script src="exportExcel/FileSaver.min.js" type="text/javascript"></script>
    <script src="exportExcel/tableexport.min.js"></script>
                    
    <!-- use the tableExport method so the user can download it if he or she wants it!-->
    <script>
        $('#tableexport').tableExport();
    </script>
    
</body>