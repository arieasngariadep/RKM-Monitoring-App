import pandas as pd
import numpy as np
import re
import sys

def openflat(namafile):
	with open(namafile, "r") as f:
		datatable = []
		for i, line in enumerate(f):
			line = line.replace("\n", "")
			data = line.split("|")
			if len(line)>81 and data[0]!="ORDERID":
				norekdb = data[2].zfill(16)
				norekkd = data[3].zfill(16)
				orderId = data[0].replace('"', '')
				mrchtTrxId = data[11].replace('"', '')
				matchingkey = orderId + data[5]
				array = [orderId, data[1], data[2], data[3], data[4], data[5], data[6], data[7], data[8], data[9], data[10], mrchtTrxId, matchingkey]
				datatable.append(array)
		return pd.DataFrame(datatable)

if __name__ == '__main__':
	df = openflat("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/Duplicate/hasil_gabung_" + sys.argv[1] + ".txt")
	df.columns = ["ORDERID", "LAST_UPDATED_TIME", "INITIATION_TIME", "STATUS", "REASON_TYPE", "TRANSACTION_AMOUNT", "MDR", "NETT_AMOUNT", "ORGANIZATION_NAME", "ORGANIZATION_SHORTCODE", "PARTNERMERCHANTID", "MERCHANTTRXID", "MATCHINGKEY"]
	df = df[~df["ORDERID"].str.contains("ORDERID")]
	df.to_excel("D:/xampp/htdocs/rkm/public/Import/folder_" + sys.argv[1] + "/Duplicate/Output.xlsx", index=False)