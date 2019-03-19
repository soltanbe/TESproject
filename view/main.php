<!DOCTYPE html>
<html>

<?php include 'view/layout/header.php'; ?>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="center">Contacts List</h1>
        </div>
    </div>
     <div class="row">
        <div class="col-md-12">
            <button class="btn btn-info" id="add_new">add new</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="contacts_table" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>phone</th>
                    <th>email</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>age</th>
                    <th>gender</th>
                    <th>insert date</th>
                    <th>action</th>
                   
                </tr>
                </thead>
            </table>
        </div>
    </div>


</div>
</body>
<?php include 'view/layout/footer.php'; ?>
</html>