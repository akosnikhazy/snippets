# I used this little script to move each imported image layer to its place in this project.
# https://www.youtube.com/watch?v=m3ujcJ8bW6A
# I made frames from a gif animation and imported them into Blender. Instead of moving them
# by hand, I used this simple Python script.

import bpy

z_c = 0
num = '0000'

for x in range(0, 146):
    y = 146-x
    z_c += 0.04
    
    if x < 10:
        num = '000'+str(x)
    elif x < 100:
        num = '00'+str(x)
    else:
        num = '0'+str(x)
    
    bpy.data.objects['V3kQW2J_'+ num +'_Layer-'+str(y)].location[0] = 0
    bpy.data.objects['V3kQW2J_'+ num +'_Layer-'+str(y)].location[2] = z_c
