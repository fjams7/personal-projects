import random
import time

options = ('ROCK', 'PAPER', 'SCISSORS')
player_score = 0
comp_score = 0
try_num = 5 # number of games


def start():
    print("Let's have a game of ROCK, PAPER, SCISSORS")
    countdown()


def countdown():
    game_time = 3
    while game_time > 0:
        print(game_time, end='', flush=True)
        print('...', end='', flush=True)
        time.sleep(0.30)
        game_time -= 1


def computer_choice(player_choice):
    rand_num = random.random()
    probability = 0.33  # N% chance that the AI counters the player's choice
    if rand_num < probability:
        return counter_choice(player_choice)
    else:
        return random.choice(options)


def counter_choice(player_choice):
    if player_choice == 'ROCK':
        return 'PAPER'
    elif player_choice == 'PAPER':
        return 'SCISSORS'
    else:
        return 'ROCK'


def game_on():
    global options, player_score, comp_score
    # Loop until a valid input has been made
    while True:
        player_input = input('\nType: ROCK, PAPER, or SCISSORS\n').upper()
        comp = computer_choice(player_input)
        if player_input == comp:
            print('Tie!')
            print('Player Score: ' + str(player_score))
            print('Computer Score: ' + str(comp_score))
            break
        elif (player_input, comp) in [('ROCK', 'SCISSORS'), ('PAPER', 'ROCK'), ('SCISSORS', 'PAPER')]:
            print('You Win!')
            player_score += 1
            print('Player Score: ' + str(player_score))
            print('Computer Score: ' + str(comp_score))
            break
        elif (player_input, comp) in [('ROCK', 'PAPER'), ('PAPER', 'SCISSORS'), ('SCISSORS', 'ROCK')]:
            print('You Lose! I picked ' + comp)
            comp_score += 1
            print('Player Score: ' + str(player_score))
            print('Computer Score: ' + str(comp_score))
            break
        else:
            print('Please select a valid choice.')


def play_again():
    global player_score, comp_score
    tries = 1
    while True:
        if tries < try_num:
            print('Get ready...')
            countdown()
            game_on()
            tries += 1
        elif tries == try_num:
            if player_score > comp_score:
                print('Final result: You win!')
            elif player_score == comp_score:
                print("Final result: It's a tie!")
            else:
                print('Final result: You lose!')
            exit()


# Main
start()
game_on()
play_again()
