import mysql.connector
import pygame
import random

# Inicializar Pygame
pygame.init()

# Conectar a la base de datos MySQL
conn = mysql.connector.connect(
    host='localhost',
    user='root',        # Cambia esto si tienes un usuario diferente
    password='',        # Cambia esto si tienes contraseña
    database='Moragas'
)
cursor = conn.cursor()

# Obtener los datos de la tabla Juego
cursor.execute("SELECT Nombre, Imagen FROM Juego")
rows = cursor.fetchall()
images = {row[0].lower(): row[1] for row in rows}

# Configuración de la pantalla
screen = pygame.display.set_mode((800, 600))
pygame.display.set_caption('Adivina la Imagen')

# Variables del juego
score = 0
font = pygame.font.Font(None, 36)
input_box = pygame.Rect(300, 500, 200, 32)
user_text = ''
running = True

# Variable para almacenar la última imagen mostrada
last_name = None

# Función para mostrar una nueva imagen
def new_image():
    global last_name
    while True:
        name, path = random.choice(list(images.items()))
        if name != last_name:
            last_name = name
            img = pygame.image.load(path)
            img = pygame.transform.scale(img, (400, 400))  # Redimensionar a 400x400
            return name, img

current_name, current_image = new_image()

# Bucle principal
while running:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_RETURN:
                if user_text.lower() == current_name:
                    score += 1
                    current_name, current_image = new_image()
                user_text = ''
            elif event.key == pygame.K_BACKSPACE:
                user_text = user_text[:-1]
            else:
                user_text += event.unicode

    screen.fill((255, 255, 255))
    screen.blit(current_image, (200, 50))  # Ajustar la posición
    txt_surface = font.render(user_text, True, (0, 0, 0))
    screen.blit(txt_surface, (input_box.x + 5, input_box.y + 5))
    pygame.draw.rect(screen, (0, 0, 0), input_box, 2)
    
    score_surface = font.render(f'Score: {score}', True, (0, 0, 0))
    screen.blit(score_surface, (10, 10))

    pygame.display.flip()

# Cerrar la conexión a la base de datos
conn.close()
pygame.quit()

