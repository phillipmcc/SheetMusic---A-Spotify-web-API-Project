import csv
import sys
import random

def main():
    print("Welcome to SheetMusic")
    print("Would You Like to \n1:login\n2:Create An Account\n3:Exit")
    choice = input("Please enter a number : ")
    if choice == '1':
        login()
    elif choice == '2':
        Adduser()
    elif choice == '3':
        print("Thank you for using SheetMusic \nGoodbye")
        sys.exit()
    else:
        print("That is not an option")
        menu()

def login():
    found = 0
    username = input("Please Enter your Username: ")
    password = input("Please Enter your Password: ")
    with open('userLogin.txt', 'r') as csvfile:
         reader = csv.reader(csvfile)
         for row in reader: 
             if (username == row[1] and password == row[2]):
                 found = 1
                 print("Login Complete")
                 global user_id 
                 user_id = row[0]
                 menu()
                 
         if(found == 0):
             print("Password is incorrect please re-enter Your Username and Password")
             login()
def menu():
    print("----------------------------------------")
    print(user_id)
    print("Welcome to SheetMusic Menu")
    print("Would You Like to \n1:Add new Book\n2:View Your Playlist\n3:View Your Books\n4:View Your Details\n5:Exit")
    choices = input("Please enter a number : ")
    if choices == '1':
        searchBook()
    elif choices == '2':
        viewPlaylist()
    elif choices == '3':
        viewBooks()
    elif choices == '4':
        details()
    elif choices == '5':
        print("Thank you for using SheetMusic \nGoodbye")
        sys.exit()
    else :
        print("Thats not an option here")
        menu()

def Adduser():
    user_id = random.randint(31,10000)  
    password = input("Please enter Your Password : ")
    username = input("Please enter Your Username : ")
    firstname = input("Please enter Your First Name : ")
    surname = input("Please enter Your Surname : ")
    email = input("Please enter Your Email : ")
    gender = input("Please enter Your Gender Between Male/Female/Other : ")
    number = input("Please enter Your Phone Number : ")
    with open('userLogin.txt', 'a') as csvfile:
        write = csv.writer(csvfile)
        write.writerow((user_id, password, username))
    csvfile.close()
    with open('userDetails.txt', 'a') as csvfile:
        write = csv.writer(csvfile)
        write.writerow((user_id, firstname, surname, gender, number, email))
    csvfile.close()
    print("Account Creation Complete")
    main()

def searchBook():
    print('----------------------------------')
    found = 0
    search = input("Please enter your search term : ")
    with open('bookDetails.txt', 'r') as csvfile:
        reader = csv.reader(csvfile)
        for row in reader: 
            if (search == row[1] or search == row[2]  or search == row[3] or search == row[4] or search == row[5]):
                 found = 1   
                 print("Book ID : " , row[0])
                 print("Book Title : " , row[1])
                 print("Book Release Year : ", row[2])
                 print("Book Author : ", row[3])
                 print("Genre : ", row[4])
                 print("Sub Genre : ", row[5])
                 print('-------------------------------')
    if found == 0:
        print("No search terms found")
        searchBook()
    elif found == 1:     
        addBook()
        print("Empty")
def viewBooks():
    found = 0
    with open('Cusbook.txt', 'r') as csvfile:
         reader = csv.reader(csvfile)
         for row in reader: 
             if user_id == row[0]:
                 book_id = row[1]
                 with open('bookDetails.txt', 'r') as csvfile:
                    reader = csv.reader(csvfile)
                    for row in reader:
                        if book_id == row[0]:
                           found = 1 
                           print("Book ID : " , row[0])
                           print("Book Title : " , row[1])
                           print("Book Release Year : ", row[2])
                           print("Book Author : ", row[3])
                           print("Genre : ", row[4])
                           print("Sub Genre : ", row[5])
                           print('-------------------------------') 
         if found == 0:
             print("You Currently have no books")
             menu()
         elif found == 1:
             menu()
    csvfile.close()
             

def details():
    found = 0 
    with open('userDetails.txt', 'rU') as csvfile:
         reader = csv.reader(csvfile)
         for row in reader: 
          if (user_id == row[0]):
                 found = 1 
                 userID = row[0]  
                 print("User ID : " , row[0])
                 print("First name : " , row[1])
                 print("Surname : ", row[2])
                 print("Gender : ", row[3])
                 print("Phone number : ", row[4])
                 print("Email : ", row[5])
                 with open ('userLogin.txt', 'r') as csvfile:
                      reader = csv.reader(csvfile)
                      for row in reader: 
                        if (userID == row[0]):
                          print("Username : " , row[1])
                          print("Password : ", row[2]) 
                          print("---------------------------------")                            
    csvfile.close()
    if found == 0:
        print("No search terms found")
        details()
    elif found == 1:
            menu()
                 
def viewPlaylist():
    print("empty")

def addBook():
    found = 0
    book = input("Please enter the book you would like to add to your collection : ")
    with open('bookDetails.txt', 'r') as csvfile:
         reader = csv.reader(csvfile)
         for row in reader: 
             if book == row[1]:
                 found = 1
                 bookid = row[0]
         if found == 0:
             print("Thats not a book currently on the system Please retry")
             addBook()
         if found == 1:
            with open('Cusbook.txt', 'a') as csvfile:
                 write = csv.writer(csvfile)
                 write.writerow((user_id, bookid))
                 csvfile.close()
                 print("Book Successfully Added")  
                 menu()




main()
