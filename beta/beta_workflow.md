This could be the next workflow
===============================
#Pages get rotated via pdftk
```sh
pdftk $file cat 1-$direction output $outpuFile
```
#The pdf gets converted to single tifs via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -r600 -o gs-%04d.tif $pdfFile
```
#Single tifs get unpapered by scantailor-cli
```sh
scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins-top=10 --default-margins-top=10 --content-detection=aggressive --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=black_and_white|color_grayscale|mixed --layout=$layout --despeckle=normal /*.tif scantailor/
```
#Text Recognition by tesseract
```sh
tesseract $fifFile $filename -l=$lang -psm=1 hocr
```
#Merge html and Pdf to Sandwich-Pdf
```sh
hocr2pdf -s -i $tifFile -o $filename.pdf < $htmlFile
```
#Combine Sandwich-Pdf to Master-Pdf
```sh
pdftk /*.pdf output $filname
```
#Write Exif-Info
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
