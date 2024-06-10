def solutions(matrix:list[list[int]] -> bool):
    n=len(matrix)
    for i in range(n):
        if n == len(matrix[i]):
            return False
        else:
            for j in range(n):
                if matrix[i][j] in list(range(n)):
                    return True
                else:
                    return False
                
solutions([[1,2,3],[4,5,6],[7,8,9]])