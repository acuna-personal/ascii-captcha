<?php
		include('captcha.php'); //���������� ������, ������������ �����
		session_start(); //��������� ������
		
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
		
		if ((!isset($_SESSION['mycaptchamd5']))||($_SERVER['REQUEST_METHOD']!='POST')) //������ �� ������� ��� ��� ������ ����� �� ���������
		{			
			$captchacode=getcaptchacode(6);	//���������� ��� �����
			$_SESSION['mycaptchamd5'] = md5($captchacode); //��������� � ������ MD5-��� ���� ������
			$pgn=getpgnum($captchacode,$allnum," ",1,true,true); //���������� ����������������� ����������� ����� �� ����
			showform($pgn); //���������� ������������ ����� ����� �����
		}
		else //������ �������
		{
			$usercodemd5=md5(trim($_POST['captchacode'])); //��������� ���, ��������� ������������� � �����. ���� ����� � ��������
			//MD5-���
			
			$gencodemd5=$_SESSION['mycaptchamd5']; //����������� ����� ����������� ���
			
			if ($usercodemd5==$gencodemd5) //�������� ������������
			{
				echo "��� ������ �����!"; //OK
				session_destroy(); //���������� ���, ���� ������������� ������ � ������. ����� ��������� ������ ����������� �����.
			}
			else //������
			{
				$captchacode=getcaptchacode(6);	//���������� ��� �����
				$_SESSION['mycaptchamd5'] = md5($captchacode); //��������� � ������ MD5-��� ���� ������
				$pgn=getpgnum($captchacode,$allnum," ",1,true,true); //���������� ����������������� ����������� ����� �� ����
				echo "<center><font color='red'>��� ������ �������, ���������� ���</font></center>";
				showform($pgn);	//���������� ������������ ����� ����� �����
			}
		}
?>