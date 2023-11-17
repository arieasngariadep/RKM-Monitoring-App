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

			data = re.split('\x00', line)
			datamentah.append(data)
			if line[16:32].isnumeric():
				org = data[1].strip()
				merch_id = data[2].strip()
				card_nbr = data[3].strip()
				amount = data[4].strip()
				if amount[-1] == "-":
					amount = amount[-1] + amount[:-1]
				else:
					amount = amount
				amount = amount.replace(",", "")
				tc = data[5].strip()

				txn_date = data[6].strip()
				date = txn_date[0:2]
				month = txn_date[2:4]
				year = txn_date[4:6]
				txn_date = date + "/" + month + "/" + year

				auth_code = data[8].strip()
				data10 = re.split('-', data[10])
				description = data10[0].strip()
				rrn = data10[1].strip()

				array = [report_date, org, merch_id, card_nbr, amount, tc, txn_date, auth_code, rrn, description]
				datatable.append(array)
		return pd.DataFrame(datatable)

if __name__ == '__main__':
	df = openflat("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/Qris/qris_" + sys.argv[1] + ".txt")
	df.columns = ["REPORT-DTE", "ORG", "MERCH-ID", "CARD-NBR", "AMOUNT", "TC", "TXN-DTE", "AUTH-CD", "DESCRIPTION", "RRN"]
	# df["AUTH-CD"] = df["AUTH-CD"].str.zfill(7)
	df.to_excel("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/Qris/HasilQris.xlsx", index=False)
