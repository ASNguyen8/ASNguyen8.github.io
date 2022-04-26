code = [" "]+[chr(97+i) for i in range(26)]


s="tic toc toc tic toc toc tic toc toc tic toc toc tic toc tic toc tic tic tic toc"
t=s.split(" ")

d = []
tmp=""
for i in range(len(t)):
    if t[i]=="toc":
        tmp+="0"
    else:
        tmp+="1"
    if (i+1)%5==0:
        d.append(tmp)
        tmp=""

for i in range(len(d)):
    k=4
    cpt=0
    while k>=0:
        cpt+=int(d[i][4-k])*(2**k)
        k-=1
    d[i]=code[cpt]

print("Message :",d)

# obtenir toutes les lettres de l'alphabet :
A = [chr(65+j) for j in range(26)]
a = [chr(97+j) for j in range(26)]

print(A)
print(a)

number = 60**2.5
print(number)
