This is the new beta-workflow
===============================
###Pages get rotated via pdftk if needed
```sh
pdftk $file cat 1-$direction output $outputFile
```
###The pdf gets converted to single tifs via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiff24nc -r600 -o gs-%04d.tif $pdfFile
```
###Single tifs get unpapered by scantailor-cli
```sh
scantailor-cli -v --enable-page-detection --enable-fine-tuning --margins=5 --default-margins=5 --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=$colormode --threshold=1 --layout=$layout --despeckle=normal *.tif scantailor/

scantailor-cli -v --enable-page-detection --enable-fine-tuning --output-dpi=335 --margins=5 --default-margins=5 --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=$colormode --threshold=1 --layout=$layout --despeckle=normal *.tif scantailor/
```
###Text Recognition by tesseract
```sh
'tesseract $tiffile $htmlfile -psm 1 -l $language hocr
```
###Merge html and tif to multilayer-compressed pdf
```sh
pdfbeads *.tif > $output.pdf
```
###Write Exif-Info (could be done by pdfbeads. to lazy right now.
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
