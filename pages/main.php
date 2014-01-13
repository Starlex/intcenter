<?php
/*try{
	$pages = $db->prepare('SELECT page_id, link, name FROM tbl_pages WHERE admin = ?');
	$pages->execute(array(0));
	$pages->setFetchMode(PDO::FETCH_ASSOC);
	$row_pages = $pages->fetchAll();
	
	$sub_pages = $db->prepare('SELECT sub_page_id, link, name, page_id FROM tbl_sub_pages WHERE admin = ?');
	$sub_pages->execute(array(0));
	$sub_pages->setFetchMode(PDO::FETCH_ASSOC);
	$row_sub_pages = $sub_pages->fetchAll();
}
catch(PDOException $e){
	showMsg('Что-то пошло не так. Попробуйте позже', '/');
}

extract(getPageNameAndLink($db));

$pageData = array(
					'link' => $link,
					'tbl_name' => $tbl_name
				);

$query =$db->prepare("SELECT COUNT(*) FROM $pageData[tbl_name] WHERE link=?");
$query->execute(array($pageData['link']));
$num = $query->fetchColumn();
if(0 === (int) $num){
	header('Location:/404');
}*/

?>
	<div class="container">
		<h3>Новости</h3>
		<?php
			$num = showNews($db);
			// pagination($num, 4);
		?>

		<div class="pagination">
			<ul>
				<li><a href="">&larr;</a></li>
				<li><a href="/1/">1</a></li>
				<li><a href="/2/">2</a></li>
				<li><a href="/3/">3</a></li>
				<li><a href="/4/">4</a></li>
				<li><a href="/5/">5</a></li>
				<li><a href="">&rarr;</a></li>
			</ul>
		</div>

		<!-- dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br>
		dsfgsdf gsdfds fgsdfg sdfdsfg sdfg sdfdsf gsdfgs dfdsfg sdfgsd fdsfgs dfgsdf dsfgs dfgsdf dsfgsdf gsdfdsf gsdfg sdfdsfg sdfgs dfdsfg sdfgsd fdsfgs dfgsd fdsfgsd fgsdfd sfgsdfgs dfdsfgsdf gsdfd sfgsdfg sdfdsfg sdfgs dfdsfgsd fgsdfd sfgsd fgsdfd sfgsdf gsdfdsfg sdfgsdf<br> -->
		<?php
		/*echo getPageContent($db, $pageData);
		if(isset($_GET['page']) and !isset($_GET['var1'])){
			try{
				$query = $db->prepare("SELECT sp.link spl, p.link pl, sp.name spn, p.name pn 
										FROM tbl_sub_pages sp
										LEFT JOIN tbl_pages p
										ON sp.page_id=p.page_id
										WHERE p.link=?");
				$query->execute(array($_GET['page']));
				$query->setFetchMode(PDO::FETCH_ASSOC);
				$row = $query->fetchAll();
				if(!empty($row)){
					echo "<h2>{$row[0]['pn']}:</h2>";
				}
				foreach ($row as $page) {
					echo "<h4><a href='$page[pl]$page[spl]'>$page[spn]</a></h4>";
				}
			}
			catch(PDOException $e){
				showMsg('Что-то пошло не так. Попробуйте позже', '/');
			}
		}*/

		?>
	</div>