import random

def generate_name():
    # List of classrooms (replace with actual classroom details if needed)
    classrooms = ["Salón Ta", "Salón Te", "Salón Ve", "Salón ka", "Salón tuk", "Salón fiu", "Salón Geo", "Salón Hed"]
    
    # List of female and male names
    females = ["Shevrena", "Aur", "irran", "Bedan", "Eve", "hevrak", "Kimore", "Ena", "Kimoaa"]
    males = ["irran", "Kimor", "Kadag", "Gibres", "Shevr", "irrenk", "Palen", "Tirian"]

    # List of surnames
    surnames = ["Tek", "ka", "alf", "orr", "bue", "kue", "ler", "Wil", "Moo", "arr", "ark", "Lew", "Gar", 
"Ade", "gue", "ack"]

    # Randomly select a name and surname
    if random.choice([True, False]):
        full_name = f"{random.choice(females)}-{random.randint(1, 8)}"
    else:
        full_name = f"{random.choice(males)}-{random.randint(1, 8)}"

    # Select a random surname
    last_name = random.choice(surnames)

    # Select a random classroom
    classroom = random.choice(classrooms)

    # Return the name and surname without the grade
    return f"{full_name} {last_name} in {classroom}"

# Print the initial phrase
print("generado nombre de personajes que viven en una luna...")

# Generate and print ten random alien names with surnames
for _ in range(10):
    print(generate_name())
