<?php
require 'connect.php'; 
if(isset($_POST['buttonImport'])) {
	copy($_FILES['xmlFile']['tmp_name'],'data/'.$_FILES['xmlFile']['name']);
	$rental = simplexml_load_file('data/'.$_FILES['xmlFile']['name']);
	foreach($rental as $rental){	//declare foreach loop 
		$stmt = $conn->prepare('insert into
			rental(rentalNumber, rentalName, rentalAge, rentalAddress)
			values(:rentalNumber, :rentalName, :rentalAge, :rentalAddress)');
		$stmt->bindValue('rentalNumber', $rental->rentalNumber);
		$stmt->bindValue('rentalName', $rental->rentalName);
		$stmt->bindValue('rentalAge', $rental->rentalAge);
		$stmt->bindValue('rentalAddress', $rental->rentalAddress);
		$stmt->execute();
	}
}
$stmt = $conn->prepare('select * from rental');
$stmt->execute();
?>

<form method="post" enctype="multipart/form-data">
	XML File 
	<input type="file" name="xmlFile"> <!-- xml file will temporary stored -->
	<br>
	<input type="submit" value="Import" name="buttonImport"> <!-- import button -->
</form>
<br>
<h3>rental</h3>
<table cellpadding="2" cellspacing="2" border="1">
	<tr>
		<th>rentalNumber</th>
		<th>rentalName</th>
		<th>rentalAge</th>
		<th>rentalAddress</th>
	</tr>
	<?php while($rental = $stmt->fetch(PDO::FETCH_OBJ)) { ?>
	<tr>
		<td><?php echo $rental->rentalNumber; ?></td>
		<td><?php echo $rental->rentalName; ?></td>
		<td><?php echo $rental->rentalAge; ?></td>
		<td><?php echo $rental->rentalAddress; ?></td>
	</tr>
	<?php } ?>
</table>