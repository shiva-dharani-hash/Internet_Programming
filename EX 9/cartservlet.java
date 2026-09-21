package controller; 

import model.CartItem; 

import jakarta.servlet.ServletException; 

import jakarta.servlet.annotation.WebServlet; 

import jakarta.servlet.http.HttpServlet; 

import jakarta.servlet.http.HttpServletRequest; 

import jakarta.servlet.http.HttpServletResponse; 

import jakarta.servlet.http.HttpSession; 

import java.io.IOException; 

import java.io.PrintWriter; 

import java.util.ArrayList; 

import java.util.List; 

@WebServlet("/CartServlet") 

public class CartServlet extends HttpServlet { 

    @Override 

    protected void doPost(HttpServletRequest request, 

                           HttpServletResponse response) 

            throws ServletException, IOException { 

        String productName = request.getParameter("productName"); 

        double price = Double.parseDouble( 

                request.getParameter("price")); 

        HttpSession session = request.getSession(); 

        List<CartItem> cart = 

                (List<CartItem>) session.getAttribute("cart"); 

        if (cart == null) { 

            cart = new ArrayList<CartItem>(); } 

        boolean productFound = false; 

        for (CartItem item : cart) { 

            if (item.getProductName().equals(productName)) { 

                item.setQuantity(item.getQuantity() + 1); 

                productFound = true; 

                break;} } 

        if (!productFound) { 

            CartItem item = 

                    new CartItem(productName, price, 1); 

            cart.add(item);} 

        session.setAttribute("cart", cart); 

        response.sendRedirect("CartServlet");} 

    @Override 

    protected void doGet(HttpServletRequest request, 

                          HttpServletResponse response) 

            throws ServletException, IOException { 

        HttpSession session = request.getSession(); 

        List<CartItem> cart = 

                (List<CartItem>) session.getAttribute("cart"); 

        response.setContentType("text/html;charset=UTF-8"); 

        PrintWriter out = response.getWriter(); 

        out.println("<!DOCTYPE html>"); 

        out.println("<html>"); 

        out.println("<head>"); 

        out.println("<title>QuickBuy - Cart</title>"); 

        out.println("<style>"); 

        out.println("body{font-family:Arial;background:#f2f2f2;margin:0;}"); 

        out.println("header{background:#264653;color:white;text-align:center;padding:22px;}"); 

        out.println(".container{width:85%;margin:30px auto;background:white;padding:25px;}"); 

        out.println("table{width:100%;border-collapse:collapse;}"); 

        out.println("th{background:#2a9d8f;color:white;padding:12px;}"); 

        out.println("td{padding:12px;border:1px solid #ddd;text-align:center;}"); 

        out.println(".total{text-align:right;font-size:20px;font-weight:bold;padding:20px;}"); 

        out.println(".button{background:#e76f51;color:white;padding:10px 18px;text-decoration:none;border-radius:5px;}"); 

        out.println("</style>"); 

        out.println("</head>"); 

        out.println("<body>"); 

        out.println("<header>"); 

        out.println("<h1>QuickBuy Shopping Cart</h1>"); 

        out.println("</header>"); 

        out.println("<div class='container'>"); 

        if (cart == null || cart.isEmpty()) { 

            out.println("<h2>Your cart is empty</h2>"); 

            out.println("<a href='products.html'>"); 

            out.println("Continue Shopping"); 

            out.println("</a>"); 

        } else { 

            out.println("<table>"); 

            out.println("<tr>"); 

            out.println("<th>Product</th>"); 

            out.println("<th>Price</th>"); 

            out.println("<th>Quantity</th>"); 

            out.println("<th>Total</th>"); 

            out.println("</tr>"); 

            double grandTotal = 0; 

            for (CartItem item : cart) { 

                double total = item.getTotal(); 

                grandTotal = grandTotal + total; 

                out.println("<tr>"); 

                out.println("<td>" + item.getProductName() + "</td>"); 

                out.println("<td>₹ " + item.getPrice() + "</td>"); 

                out.println("<td>" + item.getQuantity() + "</td>"); 

                out.println("<td>₹ " + total + "</td>"); 

                out.println("</tr>");} 

            out.println("</table>"); 

            out.println("<div class='total'>"); 

            out.println("Grand Total: ₹ " + grandTotal); 

            out.println("</div>"); 

            out.println("<div style='text-align:right;'>"); 

            out.println("<a href='products.html' class='button'>"); 

            out.println("Continue Shopping"); 

            out.println("</a>"); 

            out.println("&nbsp;&nbsp;"); 

            out.println("<a href='checkout.html' class='button'>"); 

            out.println("Checkout"); 

            out.println("</a>"); 

            out.println("</div>");} 

        out.println("</div>"); 

        out.println("</body>"); 

        out.println("</html>");}} 