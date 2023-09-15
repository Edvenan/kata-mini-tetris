# KATA 14-09-2023 - Mini Tetris

## Goal
>The algorithm is about moving a piece of tetris ('L' shape) across a 10 x 10 board
>Allowed user moves are LEFT, RIGHT, DOWN and ROTATE (Clockwise)
>The piece cannot move beyond the board limits
>More details: https://retosdeprogramacion.com/semanales2023

## Developer notes:
*   Piece 2D positions:
*       position 1 =  ⬜⬛⬛   
*                     ⬜⬜⬜
*                     ⬛⬛⬛
*   
*       position 2 = ⬛⬜⬜   
*                    ⬛⬜⬛
*                    ⬛⬜⬛
*
*       position 3 =  ⬛⬛⬛
*                     ⬜⬜⬜   
*                     ⬛⬛⬜
*   
*       position 4 =  ⬛⬜⬛
*                     ⬛⬜⬛
*                     ⬜⬜⬛
*   Center is defined by the center element of the piece which represents the rotation center

## Windows users
>Moves an options: 
- LEFT  :'a' key + ENTER
- RIGHT :'d' key + ENTER
- DOWN  :'x' key + ENTER
- ROTATE :'space' + ENTER
- QUIT  :'q' + ENTER

## Linux users
>Moves an options: 
- LEFT  : Left arrow key
- RIGHT : Right arrow key
- DOWN  : Down arrow key
- ROTATE :'Space' key
- QUIT  :'q' key
