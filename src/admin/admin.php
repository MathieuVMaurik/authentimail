<?php require 'admin.script.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Authentimail - Admin</title>
        <link rel="stylesheet" type="text/css" href="../include/style.css" />
        <script type="text/javascript" src="../include/jquery-1.11.3.js"></script>
    </head>
    <body>

        <h1>Gebruikers Account Beheer</h1>

        <p><a href="../index.php">Terug</a></p>

        <table class="admin">
            <tr>
                <th>ID</th>
                <th>Gebruikersnaam</th>
                <th>E-mail adres</th>
                <th>Beheerder</th>
                <th>Actief</th>
            </tr>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user->ID; ?></td>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><input class="admincheckbox" type="checkbox" name="admin[<?php echo $user->ID; ?>]" value="<?php echo $user->ID; ?>" <?php echo $user->is_admin == 1 ? 'checked' : ''; ?> <?php echo $user->ID == $_SESSION['user_ID'] ? 'disabled' : ''; ?> /></td>
                <td><input class="activecheckbox" type="checkbox" name="active[<?php echo $user->ID; ?>]" value="<?php echo $user->ID; ?>" <?php echo $user->active == 1 ? 'checked' : ''; ?> <?php echo $user->ID == $_SESSION['user_ID'] ? 'disabled' : ''; ?>  /></td>
            </tr>
            <?php endforeach; ?>

            <script type="text/javascript">

                $( document ).ready(function(){

                    //Change admin status when checkbox is clicked
                    $('.admincheckbox').change(function(){

                        if($(this).is(':checked'))
                        {
                            var admin = 1;
                        }
                        else
                        {
                            var admin = 0;
                        }

                        var userID = $(this).attr('value');

                        $.ajax({
                            method: "POST",
                            url: "changeadminstatus.php",
                            data: {status: admin, userID: userID}
                        })
                            .fail(function(){
                                alert('Er is een fout opgetreden. Probeer het nog eens.');
                            });
                    });

                    //Change active status when checkbox is clicked
                    $('.activecheckbox').change(function(){

                        if($(this).is(':checked'))
                        {
                            var active = 1;
                        }
                        else
                        {
                            var active = 0;
                        }

                        var userID = $(this).attr('value');

                        $.ajax({
                            method: "POST",
                            url: "changeactivestatus.php",
                            data: {active: active, userID: userID}
                        })
                            .fail(function(){
                                alert('Er is een fout opgetreden. Probeer het nog eens.');
                            });
                    });

                });

            </script>
    </body>
</html>