<%@ page language="java" contentType="text/html; charset=UTF-8"

pageEncoding="UTF-8"%>

<!DOCTYPE html>

<html>

<head>

<title>Registration Details</title>

</head>

<body>

<h2>Registration Successful</h2><%

String name = request.getParameter("name");

String email = request.getParameter("email");

String mobile = request.getParameter("mobile");

String dob = request.getParameter("dob");

String gender = request.getParameter("gender");

String qualification = request.getParameter("qualification");

String department = request.getParameter("department");

String experience = request.getParameter("experience");

String jobrole = request.getParameter("jobrole");

String location = request.getParameter("location");

String address = request.getParameter("address");%>

<p><b>Name:</b> <%= name %></p>

<p><b>Email:</b> <%= email %></p>

<p><b>Mobile:</b> <%= mobile %></p>

<p><b>Date of Birth:</b> <%= dob %></p>

<p><b>Gender:</b> <%= gender %></p>

<p><b>Qualification:</b> <%= qualification %></p>

<p><b>Department:</b> <%= department %></p>

<p><b>Experience:</b> <%= experience %></p>

<p><b>Preferred Job Role:</b> <%= jobrole %></p>

<p><b>Preferred Location:</b> <%= location %></p>

<p><b>Address:</b> <%= address %></p>

</body>

</html>