<?
	require_once __DIR__ . '/config.php';
	require_once __DIR__ . '/classes/class_database.php';
	require_once __DIR__ . '/classes/class_abstract_api.php';
	require_once __DIR__ . '/classes/class_api.php';
	require_once __DIR__ . '/classes/class_engine.php';

	$eng = new Engine;
	$eng->getNews(array($reposterKeywords[0] . $reposterKeywords[1], 200));
	$eng->parseNews();
	$eng->checkPublics();
	$eng->joinPublics();
?>

<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</html>