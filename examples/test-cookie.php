<?php

		//������� ��������� ������� � �������������� ��������� cookie 
		//����� �������� ���� �� ���������� ������� ������
		//�������� ���������� ������, ���� �� ����������� ���������� ������ � ������� ������
		
		include('captcha.php'); //���������� ������, ������������ �����		
		
		function showform($pgn) //�������, ������� ������ ����� � �������
		{
			echo "<center>";
			
			echo ("<pre><code>".$pgn."</code></pre>");
			
			echo "<form action='".$_SERVER['PHP_SELF']."' method='POST'>
				<p><b>������� ����������� ���</b></br>
				<p><input type='text' name='captchacode'></p>
				<p><input type='submit' value='���������'></p>
			</form>";
			echo "</center>";
		}
		
		if ((!isset($_COOKIE['mycaptchamd5']))||($_SERVER['REQUEST_METHOD']!='POST')) //������ �� ������� ��� ��� ������ ����� �� ���������
		{			
			$captchacode=getcaptchacode(6);	//���������� ��� �����
			setcookie('mycaptchamd5',md5($captchacode),time()+300); //��������� � cookie MD5-��� ���� ������, ������������� ����� �������� � 5 �����
			$pgn=getpgnum($captchacode,$allnum," ",1,false,false); //���������� ����������������� ����������� ����� �� ����
			showform($pgn); //���������� ������������ ����� ����� �����
		}
		else //������ �������
		{
			$usercodemd5=md5(trim($_POST['captchacode'])); //��������� ���, ��������� ������������� � �����. ���� ����� � ��������
			//MD5-���
			
			$gencodemd5=$_COOKIE['mycaptchamd5']; //����������� ����� ����������� ���
			
			if ($usercodemd5==$gencodemd5) //�������� ������������
			{
				//��� �������, ����� ������� cookie � ����� ������ ����� ������ ��������
				setcookie("mycaptchamd5","",time()-300); 
				echo "��� ������ �����!"; //OK								
			}
			else //������
			{
				$captchacode=getcaptchacode(6);	//���������� ��� �����
				setcookie('mycaptchamd5',md5($captchacode),time()+300); //��������� � cookie MD5-��� ���� ������, ������������� ����� �������� � 5 �����
				$pgn=getpgnum($captchacode,$allnum," ",1,true,true); //���������� ����������������� ����������� ����� �� ����
				echo "<center><font color='red'>��� ������ �������, ���������� ���</font></center>";
				showform($pgn);	//���������� ������������ ����� ����� �����
			}
		}
?>