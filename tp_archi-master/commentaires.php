<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="contenu" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
			$lien=mysqli_connect("localhost","root","root","tp");
			if(isset($_POST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$contenu=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['contenu'])));
				$req="INSERT INTO comment VALUES (NULL,'$nom','$contenu')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}

			if(!isset($_GET['page']) || $_GET['page']<1)
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=3;
			$premiercomm=$commparpage*($page-1);
			$req="SELECT * FROM comment ORDER BY id LIMIT $premiercomm,$commparpage";/* LIMIT dit ou je commence et combien j'en prends*/
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<h2>".$tableau['nom']."</h2>";
					echo "<p>".$tableau['contenu']."</p>";
				}
			}

			$req="SELECT * FROM comment";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un r�sultat.
				$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier sup�rieur*/
				echo "<br> Pages : ";
				echo "<a href='commentaires.php?page=1'> << </a>";
				echo "<a href='commentaires.php?page=".($page-1)."'> < </a>";
				if($page==1){
					for($i=($page);$i<=($page+2);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				}
				elseif ($page==2) {
					for($i=($page-1);$i<=($page+2);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				}
				else{
					for($i=($page-2);$i<=($page+2);$i++)
					{
						echo "<a href='commentaires.php?page=$i'> $i </a>";
					}
				}
			}
			echo "<a href='commentaires.php?page=".($page+1)."'> > </a>";
			echo "<a href='commentaires.php?page=$nbpages'> >> </a>";

			mysqli_close($lien);
		?>
