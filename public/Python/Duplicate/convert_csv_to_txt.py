import glob
import sys
import os
import pandas as pd

excel_files = glob.glob('D:/xampp/htdocs/rkm/public/Import/folder_' + sys.argv[1] + '/Duplicate/*.csv') # assume the path
for excel in excel_files:
    fileExcel = excel[53:]
    filename = fileExcel[:-4]
    out ='D:/xampp/htdocs/rkm/public/Import/folder_' + sys.argv[1] + '/Duplicate/' + filename + '.txt'
    df = pd.read_csv(excel)
    df.to_csv(out, index=None, sep="|") 