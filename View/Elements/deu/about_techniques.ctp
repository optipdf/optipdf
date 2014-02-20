####Technische Informationen
[CakePHP](http://cakephp.org/ "cakephp project site") ist, bei aktiviertem Caching, ein recht schnelles Framework.
Mit seiner bake shell ist es uns möglich schnelle Entwürfe zu erstellen und stellte so eine Ideale Basis für dieses Projekt dar.
Pdf-Optimierung ist eine zeitraubende Aufgabe, auch auf unserem schnellen Server.
Aus diesem Grund entschieden wir uns einen Jobserver Jobserver([Gearman](http://gearman.org/ "gearman job server")) zu benutzen, der Ihnen eine E-Mail schickt, wenn das Pdf optimiert ist.
Wir danken [Lorenzo](https://github.com/lorenzo "Lorenzo alias jose_zap auf github") für dieses enorm nützliche [cakephp-gearman](https://github.com/lorenzo/cakephp-gearman "cakephp gearman plugin") plugin.
Außerdem danken wir der Cake-IRC Community (especially [savant](http://josediazgonzalez.com/ "savant on github") und [dereuromark](http://www.dereuromark.de/ "dereuromark")) dafür, uns immer geholfen zu haben, wenn wir vor Problemen bei der Benutzung von CakePHP standen.
####Benutzte Software (in der Reihenfolge ihrer Benutzung)
- Bilderstellung: [GPL Ghostscript 9.05](http://www.ghostscript.com/ "Ghostscript, an interpreter for the PostScript language and for PDF")
- Bilddrehung: [PDFtk 1.44](http://www.pdflabs.com/ "PDF Labs the Producers of PDFtk")
- Texterkennung: [tesseract 3.02.02](https://code.google.com/p/tesseract-ocr/ "An OCR Engine that was developed at HP Labs between 1985 and 1995... and now at Google.")
- Bildoptimierung: [scantailor enhanced Jan 6 2014](http://sourceforge.net/projects/scantailor/ "Scan Tailor is an interactive post-processing tool for scanned pages.")
- Multilayerkompression und Ausgabe: [pdfbeads RMagick 2.13.2](https://github.com/ifad/pdfbeads "PDFBeads is a small utility written in Ruby which takes scanned page images and converts them into a single PDF file.")
- Metadaten: [exiftool 8.60](http://www.sno.phy.queensu.ca/~phil/exiftool/ "ExifTool is a platform-independent Perl library plus a command-line application for reading, writing and editing meta information in a wide variety of files.")