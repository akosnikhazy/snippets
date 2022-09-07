# because sometimes you want a list of bits not a string of them by bin()

def int_to_bin_list(int):
    bin = []
    while True:
        bin.append(int % 2)
        int = int // 2
        if int == 0:
            return list(reversed(bin))
