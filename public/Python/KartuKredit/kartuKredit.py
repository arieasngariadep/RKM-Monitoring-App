import pandas as pd
import datetime
import numpy as np
import re
import sys

def openflat(namafile):
	with open(namafile, "r", encoding='utf-8', errors='replace') as f:
		fileName = sys.argv[2]
		report = re.split(r'\.',fileName)
		reportName = report[2]+'.'+report[3]

		datatable = []
		newIndex = 0
		noMerchant = 0
		for i, line in enumerate(f):
			if len(line) > 0 and line[0] == "1": newIndex = i

			if i>=newIndex and i<=newIndex+9:
				data = re.split(r'\s{2,}', line)
				if i==newIndex+1: 
					noMerchant = line[:11].strip()
					bankName = line[40:104].strip()
				if i==newIndex+2:
					namaMerchant = line[:38].strip()
				if i==newIndex+4:
					noRek = line[43:80].strip()
				if i==newIndex+5:
					namaRek = line[43:80].strip()
				if i==newIndex+8:
					procDate = line[12:24].strip()
					procDate = datetime.datetime.strptime(procDate,'%d/%m/%y').strftime('%Y-%m-%d')
			else:
				data = re.split(r'\s{1,}', line)
				if len(data)==11:
					data.insert(1, "")
					
			if i>newIndex+9 and "." in line[80:81]:

				if(data[1] == ""):
					oo_batch = line[:6].strip()
					txn_date = line[24:32].strip()
					txn_date = datetime.datetime.strptime(txn_date,'%d/%m/%y').strftime('%Y-%m-%d')
					auth = line[33:39].strip()
					cardnum = line[40:59].replace("-", "").strip()
					ss = line[59:62].strip()
					amount = line[62:77].replace(",", "").strip()
					rate = line[79:84].strip()
					disc_amount = line[89:98].strip()
					if disc_amount == '0':
						disc_amount = '0'
					else:
						disc_amount = disc_amount.replace(",", "")					
						
				else:
					oo_batch = line[:6]
					txn_date = line[24:32].strip()
					txn_date = datetime.datetime.strptime(txn_date,'%d/%m/%y').strftime('%Y-%m-%d')
					auth = line[33:39].strip()
					cardnum = line[40:59].replace("-", "").strip()
					ss = line[59:62].strip()
					amount = line[62:77].replace(",", "").strip()
					rate = line[79:84]
					disc_amount = line[89:98].strip()
					if disc_amount == '0':
						disc_amount = '0'
					else:
						disc_amount = disc_amount.replace(",", "")						

				if(amount[-1] == "-"):
					amount = amount.replace("-", "")
					amount = "-" + amount
				else:
					amount = amount

				if(disc_amount[-1] == "-"):
					disc_amount = disc_amount.replace("-", "")
					disc_amount = "-" + disc_amount
				else:
					disc_amount = disc_amount

				net_amount = int(amount) - int(disc_amount)

				array = [oo_batch, txn_date, auth, cardnum, amount, rate, disc_amount,net_amount, noMerchant,bankName, namaMerchant, noRek,namaRek, procDate,reportName,ss]
				datatable.append(array)
		return pd.DataFrame(datatable)

if __name__ == '__main__':
	df = openflat("D:/xampp/htdocs/rkm/public/Import/KartuKredit/folder_" + sys.argv[1] + "/" + sys.argv[2])
	df.columns = ["OO BATCH","TXN-DATE","AUTH","CARD NUMBER","AMOUNT","RATE","DISC.AMT","NET_AMOUNT","NO.MERCHANT","BANK NAME","MERCHANT NAME","NO.REK","REK NAME","PROC DATE","REPORT NAME","SS"]

	df.to_excel("D:/xampp/htdocs/rkm/public/Import/KartuKredit/hasil_kartuKredit_" + sys.argv[1] + ".xlsx", index=False)