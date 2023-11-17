import pandas as pd
import numpy as np
import re
import sys

def openflat(namafile):
	with open(namafile, "r") as f:
		datamentah = []
		datatable = []
		newIndex = 0
		report_date = 0
		for i, line in enumerate(f):
			if len(line) > 0 and line[0] == "1": newIndex = i

			if i>=newIndex and i<=newIndex+4:
				if i==newIndex: 
					report_date = line[110:118].strip()
	
			else:
				data = re.split(r'\s{1,}', line)
				if len(data)==11:
					data.insert(1, "")

			line = line.replace("\n", "")
			line = line.replace("\x00", "")
			data = re.split(r'\s{2,}', line)
			datamentah.append(data)
			if line[49:55].isnumeric():
				org = line[:5].strip()
				merch_id = line[5:15].strip()
				card_nbr = line[15:32].strip()
				amount = line[32:44].strip()
				if amount[-1] == "-":
					amount = amount[-1] + amount[:-1]
				else:
					amount = amount
				amount = amount.replace(",", "")
				tc = line[44:48].strip()

				txn_date = line[48:55].strip()
				date = txn_date[0:2]
				month = txn_date[2:4]
				year = txn_date[4:6]
				txn_date = date + "/" + month + "/" + year

				auth_code = line[55:63].strip()
				description = line[63:90].strip()

				array = [report_date, org, merch_id, card_nbr, amount, tc, txn_date, auth_code, description]
				datatable.append(array)
		return pd.DataFrame(datatable)

if __name__ == '__main__':
	df = openflat("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/LinkAja/linkAja_" + sys.argv[1] + ".txt")
	df = df.applymap(lambda x: x.encode('unicode_escape').
                 decode('utf-8') if isinstance(x, str) else x)
	df.columns = ["REPORT-DTE", "ORG", "MERCH-ID", "CARD-NBR", "AMOUNT", "TC", "TXN-DTE", "AUTH-CD", "DESCRIPTION"]
	df.to_excel("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/LinkAja/HasilLinkAja.xlsx", index=False)
