<h2 >Projekte</h2>
<?php

if($loginFunctions->isLoggedIn()) {
 } else {
    print'Seite nicht verfügbar';
    return;
}
if (isset($_POST['name'])) {
        $result = $userService->create_project(
        $loginFunctions->getCurrentUser('id'),
        $_POST['name']
        );
     if ($result->status == 'ok') {
            print '<span class="erfolgsmeldung">Projekt erfolgreich hinzugefügt</span>';
        } else {
            foreach ($result->reason as $reason) {
                print '<span class="Fehlermeldung">' . $reason . '</span><br />';
            }
        } 
} 


$name = array();
$statement = $pdo->prepare('SELECT name FROM projekte');
$statement->execute();
$name = $statement->fetchAll();





$result = $userService->get_projects($loginFunctions->getCurrentUser('id'),
    'all'
    );
?>


<div class="project clearfix">
        <div class="projectName"> 
            <form method="post" action="?section=projekte">
                
                <input type="text" name="name"/>
                <input type="submit" value="erstellen" />
                
               
            </form>
        </div> 
        <div class="projectActions">
            <div class="projectActionsVerticalBox">
                <b>Versionen</b>
                <form action="?section=push&project=<?= $row->id ?>" method="post">
                    <input type="submit" disabled="disabeld" value="Push from" />
                    <input type="text" value="" disabled="disabled" name="ordner" />
                </form>
            </div>
            <div class="projectActionsVerticalBox">
                <b href="?section=project_bearbeiten&id=<?= $row->id ?>">bearbeiten</b>
                <br/>
                <b href="?section=project_loeschen&delete=1&project=<?= $row->id ?>">loeschen</b>
            </div>
        </div>
    </div>

<?php foreach ($result as $row) { ?>
    <div class="project clearfix">
        <div class="projectName"> 
            <?= $row->id . '-' . $row->name; ?>
        </div> 
        <div class="projectActions">
            <div class="projectActionsVerticalBox">
                <a href="?section=pull&project=<?= $row->id ?>">Versionen</a>
                <form action="?section=push&project=<?= $row->id ?>" method="post">
                    <input type="submit" value="Push from" />
                    <input type="text" value="" name="ordner" />
                </form>
            </div>
            <div class="projectActionsVerticalBox">
                <a href="?section=project_bearbeiten&id=<?= $row->id ?>">bearbeiten</a>
                <a href="?section=project_loeschen&delete=1&project=<?= $row->id ?>">loeschen</a>
            </div>
        </div>
    </div>
<?php }



       


?>


