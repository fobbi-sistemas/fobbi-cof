<?php    
    ob_start();
    session_start();
    
    // verifica se ultima atividade foi mais de 12 horas atrás
    if (isset($_SESSION['ultima_atividade']) && (time() - $_SESSION['ultima_atividade'] > 43200)) {
        session_unset();     // unset $_SESSION  
        session_destroy();   // destroindo session data 
    }
    
    $_SESSION['ultima_atividade'] = time(); // update da ultima atividade

    if (!isset($_SESSION['idUsuarioFobbiSiteAdmin'])) {
        session_unset();
        session_destroy();
        header("Location: ../../../login");   
    }
    
?>