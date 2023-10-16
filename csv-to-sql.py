"""

  Just a very simple .csv to .sql file converter
  that I will modify and use for the eventual
  CSV file I need to put into a MySQL database.
  
"""

import csv
"""
  ini
"""
sql = "INSERT INTO table (`col1`, `col2`) VALUES "
csvfile = 'yourfile.csv'
outputfile = 'database.sql'

"""
  read line commets for things to change
"""
values = []
with open(csvfile, newline='',encoding="utf-8") as csvf:
    read = csv.reader(csvf, delimiter=';', quotechar='"')

    for row in read:
        # to see what happens. It meaks everything much slower
        # print('("' + '","'.join([row[1], row[2]]) + '")')
        
      """
        change the row[x] variables based on what 
        values you want in your .sql file
      """
        values.append('("' + '","'.join([ row[1], row[2]]) + '")')

sql = sql + ','.join(values)

with open(outputfile, 'a', encoding='utf-8') as msql:
   msql.write(sql)
