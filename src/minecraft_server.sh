#! /bin/bash 

source minecraft.conf

[ -f ${pid_file} ] && source ${pid_file}

date=$(date '+%Y-%m-%d %H:%M:%S')

function server_start {
  if ! is_started; then
    nohup ${cmd} > ${minecraft_output_log} 2> ${minecraft_error_log} & echo "minecraft_pid=$!" > ${pid_file}
    echo "minecraft_started=\"${date}\"" >> ${pid_file}

    echo "[${date}] Server start" >> ${minecraft_status_log}
    echo "Server start"
  else
    echo "Error: Server already started." >&2
    echo "try \"$0 restart\" instead"
  fi
}

function server_stop {
  if is_started; then
    kill -9 ${pid}
    rm ${pid_file}
 
    echo "[${date}] Server stop" >> ${minecraft_status_log}
    echo "Server stopped"
  else
    echo "Error: Can not stop server if not running"
  fi
}

function is_started {
  if [ "x${pid}" == "x" ]; then
    return 1
  else
    if [ $(ps -q ${pid} -o comm=) = "java" ]; then
      return 0
    else
      rm ${pid_file}
      return 1
    fi
  fi
}

function usage {
  echo "Usage: $0 [start|stop|restart|status]"
}

function error {
  echo "Error : $@"
  usage
  exit 1
}

function main {
  if [ "$#" -eq 1 ]; then
    case $1 in
      start | stop | status)
	server_$1
	;;
      restart)
	server_stop
	server_start
	;;
      --help | -h)
	usage
	;;
      *)
	error $0 $1
	;;
    esac
  else
    error $0 $@
  fi
}

main $@
