<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "Khunanon Sareema\n";
fwrite($myfile, $txt);
$txt = "Kunano\n";
fwrite($myfile, $txt);
fclose($myfile);
echo "บันทึกข้อมูลเรียบร้อย";
?>