# UTH Lập trình web nâng cao

search2(){
while true; do
echo "Hãy nhập họ tên sinh viên mà bạn muốn tìm";
read input;
echo "INput: $input";

    	#Dùng để lấy ra dc chuỗi cuối cùng
    	tenSV=$( echo $input | rev | cut  -f1 -d" "| rev);

    	#Dùng để lấy ra chuỗi còn lại dựa trên chuỗi cuối cùng
    	hoTenDem=$( echo $input | rev | cut -f2- -d" " | rev);

    	echo "HoTen $hoTenDem";
    	echo "TenSV $tenSV";

    	#if [[ "$hoTenDem" =~ ^[a-zA-Z]+$ ]] && [[ "$tenSV" =~ ^[a-zA-Z]+$ ]]; then
    		if (( $(isHoTenExists $hoTenDem $tenSV) != 1 )) 2>/dev/null ; then
    		    echo "Không có sinh viên nào phù hợp với yêu cầu !! Vui lòng nhập lại";
    		    continue;
    		else
                thongTinByHoTen $hoTen $tenSV;

                echo "Bạn có muốn tiếp tục nhập ? Ấn 0 để thoát nếu bạn muốn";
                read choice;
                [[ "$choice" == "0" ]] && break;
    		fi
    	#else
    		#echo "Họ tên sinh viên không được chứa số và các ký tự đặc biệt !!"
    	#fi
    done

}
