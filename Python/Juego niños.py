import pygame
import mysql.connector
import os

pygame.init()

WIDTH, HEIGHT = 800, 600
screen = pygame.display.set_mode((WIDTH, HEIGHT))
pygame.display.set_caption("Mis Compañeros")

BLACK = (0, 0, 0)
WHITE = (255, 255, 255)

def obtener_compañeros():
    conexion = mysql.connector.connect(
        host="localhost",
        user="root",  
        password="",  
        database="Moragas"
    )
    
    cursor = conexion.cursor(dictionary=True)
    cursor.execute("SELECT Nombre, imagen FROM Juego2")
    compañeros = cursor.fetchall()
    
    cursor.close()
    conexion.close()
    
    return compañeros

children = obtener_compañeros()

currentChildIndex = 0

font = pygame.font.SysFont("Arial", 50)

def show_child(index):
    child = children[index]
    
    screen.fill(BLACK)
    
    image_path = child["imagen"]
    image = pygame.image.load(image_path)
    image = pygame.transform.scale(image, (400, 400))
    screen.blit(image, (WIDTH//2 - 200, HEIGHT//2 - 200))
    
    text_surface = font.render(child["Nombre"], True, WHITE)
    screen.blit(text_surface, (WIDTH//2 - text_surface.get_width()//2, 50))
    
    pygame.display.update()

show_child(currentChildIndex)

running = True
while running:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False

        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_SPACE:
                currentChildIndex = (currentChildIndex + 1) % len(children)
                show_child(currentChildIndex)

pygame.quit()


