<?php
/**
* http://php.net/manual/es/book.zip.php
*/
function delTree($dir) { 
    $files = array_diff(scandir($dir), array('.','..')); 
     foreach ($files as $file) 
       (is_dir("$dir/$file")) ? delTree("$dir/$file") : @unlink("$dir/$file"); 
     return @rmdir($dir); 
} 

$tempfolder = '/tmp/temporales/' . hash('sha256', rand() ) . '/';
mkdir( $tempfolder, 0777, true );

$acum=strtotime("now");
$zip_temporal = $tempfolder . 'test_'.$acum.'.pptx';
copy( 'test.pptx', $zip_temporal);

$zip = new ZipArchive;
$res = $zip->open( $zip_temporal);
if ($res === TRUE) {
    
        $zip->extractTo( $tempfolder);
        $fichero = 'ppt/media/image1.png';
        unlink($tempfolder .$fichero );
        copy('c:/xampp/htdocs/opentbs/images/flower.png', $tempfolder .$fichero);


       $zip->addFile($tempfolder .$fichero, 'ppt/media/image1.png' );
       $slide1 = file_get_contents( $tempfolder . 'ppt/slides/slide1.xml' );
       $slide1 = str_replace( 'Test de test', 'Testul reusit', $slide1 );
       $zip->addFromString('ppt/slides/slide1.xml', $slide1 );
       $zip->close();

} else {
       echo 'failed';
}
copy ($tempfolder . 'test_'.$acum.'.pptx','c:\xampp\htdocs\tester\test_'.$acum.'.pptx');
/*
header('Content-Description: File Transfer');
header('Content-type: application/vnd.openxmlformats-officedocument.presentationml.presentation' );
header('Content-Disposition: attachment; filename=""test_'.$acum.'.pptx""');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize( $zip_temporal ) );
readfile( $zip_temporal );
*/
// Elimino el directorio temporal
delTree( $tempfolder );
?>
