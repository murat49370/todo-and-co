#!/bin/bash



# Nom de la session screen
SCREEN_NAME="QUIL"
ERROR_PATTERN="pre_midnight_proof_worker.go:137"
INCREMENT_PATTERN="increment"
CHECK_INTERVAL=10
ERROR_WAIT_TIME=480
RESTART_WAIT_TIME=120 
COUNTDOWN_INTERVAL=30

echo ""
echo -e "\e[33m"
echo "                                                                                                                      "
echo "                                               .,                     ,                                               "
echo "                                              ,Wt .    .           f#i j.                      L                     "
echo "            ;                .. GEEEEEEEL    i#D  Di   Dt        .E#t  EW,                     #K:    :;;;;;;;;;;;;;."
echo "          .DL               ;W,    L#K      f#f   E#i  E#i      i#W,   E##j               jt   :K#t    jWWWWWWWW###L "
echo "  f.     :K#L     LWL      j##,    t#E    .D#i    E#t  E#t     L#D.    E###D.             G#t    L#G.          ,W#f  "
echo "  EW:   ;W##L   .E#f      G###,    t#E   :KW,     E#t  E#t   :K#Wfff;  E#jG#W;  .......   E#t     t#W,        ,##f   "
echo "  E#t  t#KE#L  ,W#;     :E####,    t#E   t#f      E########  i##WLLLL  E#t t##f  GEEEEEE  E#t  .jffD##f      i##j    "
echo "  E#t f#D.L#L t#K:     ;W#DG##,    t#E    ;#G     E#j  K#j    .E#L     E#t  :K#E:         E#t  .fLLLD##L    i##t     "
echo "  E#jG#f  L#LL#G      j### W##,    t#E     :KE.   E#t  E#t      f#E:   E#KDDDD###i        E#t     ;W#i     t##t      "
echo "  E###;   L###j      G##i,,G##,    t#E      .DW:  E#t  E#t       ,WW;  E#f,t#Wi,          E#t    j#E.     t##i       "
echo "  E#K:    L#W;     :K#K:   L##,    t#E        L#, f#t  f#         .D#; E#t  ;#W:          E#t  .D#f      j##;        "
echo "  EG      LE.     ;##D.    L##,     fE         jt  ii   ii          tt DWi   ,KK:         tf,  KW,      :##,         "
echo "  ;       ;@      ,,,      .,,       :                                                                  ,W,          "
echo "                                                                                                                      "
echo -e "\e[34m"                                                                                                               
echo "                                                                                                          by Reegz    "
echo -e "\e[0m"
echo ""       





# Fonction pour vérifier et lancer le screen si nécessaire
check_and_launch_screen() {
    if ! screen -list | grep -q "\.$SCREEN_NAME"; then
        echo -e "\e[33m$(date '+%Y-%m-%d %H:%M:%S') - Screen session '$SCREEN_NAME' not found. Launching...\e[0m"
        screen -S $SCREEN_NAME -dm bash -c '/bin/bash ./release_autorun.sh'
        if [ $? -eq 0 ]; then
            echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - Screen session '$SCREEN_NAME' launched successfully.\e[0m"
        else
            echo -e "\e[31m$(date '+%Y-%m-%d %H:%M:%S') - Failed to launch screen session '$SCREEN_NAME'.\e[0m"
            exit 1
        fi
    else
        echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - Screen session '$SCREEN_NAME' already exists.\e[0m"
    fi
}

# Fonction pour extraire increment et vérifier l'erreur
monitor_screen() {
    last_increment=0

    while true; do
        # Capture la sortie de la session screen dans un fichier temporaire
        screen -S $SCREEN_NAME -X hardcopy /tmp/screen_output.txt
        
        # Extraire la dernière valeur de increment
        current_increment=$(grep "$INCREMENT_PATTERN" /tmp/screen_output.txt | tail -n 1 | awk -F'"increment":' '{print $2}' | awk -F'[^0-9]+' '{print $1}')
        
        # Afficher la valeur de increment uniquement si elle a changé
        if [[ -n "$current_increment" && "$current_increment" != "$last_increment" ]]; then
            last_increment=$current_increment
            echo -e "\e[33m$(date '+%Y-%m-%d %H:%M:%S') - Current increment value: $last_increment\e[0m"
        fi

        # Vérifier si l'erreur est présente dans la sortie
        if grep -q "$ERROR_PATTERN" /tmp/screen_output.txt; then
            echo -e "\e[31m$(date '+%Y-%m-%d %H:%M:%S') - Error detected: $ERROR_PATTERN. Starting 10-minute countdown for restart.\e[0m"
            
            # Initialiser le compte à rebours
            remaining_time=$ERROR_WAIT_TIME
            initial_increment=$last_increment

            # Compte à rebours avec vérification de l'increment
            while [ $remaining_time -gt 0 ]; do
                # Recharger la sortie de l'increment
                screen -S $SCREEN_NAME -X hardcopy /tmp/screen_output.txt
                current_increment=$(grep "$INCREMENT_PATTERN" /tmp/screen_output.txt | tail -n 1 | awk -F'"increment":' '{print $2}' | awk -F'[^0-9]+' '{print $1}')

                # Vérifier si l'increment diminue
                if [[ -n "$current_increment" && "$current_increment" -lt "$initial_increment" ]]; then
                    echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - Increment is decreasing. Canceling restart countdown.\e[0m"
                    break
                fi

                echo -e "\e[33m$(date '+%Y-%m-%d %H:%M:%S') - Time left before restart: $remaining_time seconds\e[0m"
                sleep $COUNTDOWN_INTERVAL
                remaining_time=$((remaining_time - COUNTDOWN_INTERVAL))
            done

            # Si le temps restant est écoulé, redémarrer
            if [ $remaining_time -le 0 ]; then
                echo -e "\e[31m$(date '+%Y-%m-%d %H:%M:%S') - Restarting application in $RESTART_WAIT_TIME seconds.\e[0m"
                screen -S $SCREEN_NAME -X quit
                sleep $RESTART_WAIT_TIME
                GOMAXPROCS=16 screen -S $SCREEN_NAME -dm bash -c '/bin/bash ./release_autorun.sh'
                
                if [ $? -eq 0 ]; then
                    echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - Application restarted successfully in screen '$SCREEN_NAME'.\e[0m"
                else
                    echo -e "\e[31m$(date '+%Y-%m-%d %H:%M:%S') - Failed to restart the application in screen '$SCREEN_NAME'.\e[0m"
                fi
            else
                echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - Countdown canceled due to increment change.\e[0m"
            fi

        else
            echo -e "\e[32m$(date '+%Y-%m-%d %H:%M:%S') - No error detected.\e[0m"
        fi

        sleep $CHECK_INTERVAL
    done
}

# Lancer la vérification et le monitoring
check_and_launch_screen
monitor_screen
