def add(x, y):
    return x + y

def subtract(x, y):
    return x - y

def multiply(x, y):
    return x * y

def divide(x, y):
    if y != 0:
        return x / y
    else:
        return "Cannot divide by zero!"

def modulus(x, y):
    if y != 0:
        return x % y
    else:
        return "Cannot divide by zero!"

print("Python Calculator")
print("Choose an operation:")
print("1. Addition")
print("2. Subtraction")
print("3. Multiplication")
print("4. Division")
print("5. Modulus Division")

while True:
    type = int(input("Enter operation type (1-5): "))
    if type >= 1 and type <= 5:
        if type == 1:
            print("Selected Operation: ADDITION")
        elif type == 2:
            print("Selected Operation: SUBTRACTION")
        elif type == 3:
            print("Selected Operation: MULTIPLICATION")
        elif type == 4:
            print("Selected Operation: DIVISION")
        elif type == 5:
            print("Selected Operation: MODULUS DIVISION")

        num1 = float(input("Enter the first number: "))
        num2 = float(input("Enter the second number: "))

        if type == 1:
            result = add(num1, num2)
            print("Sum: ", result)
        elif type == 2:
            result = subtract(num1, num2)
            print("Difference: ", result)
        elif type == 3:
            result = multiply(num1, num2)
            print("Product: ", result)
        elif type == 4:
            result = divide(num1, num2)
            print("Quotient: ", result)
        elif type == 5:
            result = modulus(num1, num2)
            print("Remainder: ", result)
        break  # exits while loop if a valid number is entered
    else:
        print("Only numbers 1-5 are allowed.")
