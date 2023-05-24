import random
import time

options = ('ROCK', 'PAPER', 'SCISSORS')
again = ('Y', 'N')
def start():
    print("Lets have a game of ROCK, PAPER, SCISSORS")
    countdown()
def countdown():
    game_time = 3
    while game_time > 0:
        print(game_time, end='', flush=True)
        print('...', end='', flush=True)
        time.sleep(0.75)
        game_time -= 1
def game_on():
    comp = random.choice(options)
    # loops until a valid input has been made
    while True:
        player_input = input('\nType: ROCK, PAPER, or SCISSORS\n').upper()
        if player_input == comp:
            print('Tie!')
            break
        elif (player_input, comp) in [('ROCK', 'SCISSORS'), ('PAPER', 'ROCK'), ('SCISSORS', 'PAPER')]:
            print('You Win!')
            break
        elif (player_input, comp) in [('ROCK', 'PAPER'), ('PAPER', 'SCISSORS'), ('SCISSORS', 'ROCK')]:
            print('You Lose! I picked' + comp)
            break
        else:
            print('Please select a valid choice.')
def play_again():
    #loops until a valid input has been made
    while True:
        player_choice = input('Do you want to play again? Enter Y/N: ').upper()
        if player_choice == 'Y':
            print('Get ready...')
            countdown()
            game_on()
        elif player_choice == 'N':
            exit()
        else:
            print('Y/N only')
#main
start()
game_on()
play_again()