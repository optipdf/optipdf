This is our current workflow:

pages get rotated via pdftk
```sh
pdftk $file cat 1-$direction output $outpuFile
```
the pdf gets converted to single tifs via ghostscript
```sh
gs -dNOPAUSE -dBATCH -sDEVICE=tiffg4 -r600 -o gs-%04d.tif $pdfFile
```
Single tifs get unpapered by scantailor-cli
```sh
scantailor-cli -v --enable-page-detection --output-dpi=300 --enable-fine-tuning --margins-top=10 --default-margins-top=10 --content-detection=aggressive --alignment-vertical=top --alignment-horizontal=center --white-margins=true --normalize-illumination=true --tiff-compression=none --color-mode=black_and_white|color_grayscale|mixed --layout=$layout --despeckle=normal /*.tif scantailor/
```
blabla tifToHtml
```sh
tesseract $fifFile $filename -l=$lang -psm=1 hocr
```
blabla htmlToPdf
```sh
hocr2pdf -s -i $tifFile -o $filename.pdf < $htmlFile
```
blabla pdfcombine
```sh
pdftk /*.pdf output $filname
```

```
blabla exIf
```sh
exiftool -overwrite_original -Title=$title -Author=$author $filename
```
