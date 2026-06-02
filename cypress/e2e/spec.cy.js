describe("Product HTTP Request", () => {
    // GET All Data Product Request
    it("GET Request", () => {
        cy.request("GET", "http://127.0.0.1:8000/api/products")
            .its("status")
            .should("equal", 200);
    });
    // GET Product By ID Request
    it("GET By ID Request", () => {
        cy.request("GET", "http://127.0.0.1:8000/api/products/1")
            .its("status")
            .should("equal", 200);
    });
    // POST Product Request
    it("POST Request", () => {
        cy.request({
            method: "POST",
            url: "http://127.0.0.1:8000/api/products",
            body: {
                category_id: 1,
                product_name: "Frisian Flag",
                product_stock: 200,
                product_price: 25000,
            },
        })
            .its("status")
            .should("equal", 201);
    });
    // PATCH Product Request
    it("PATCH Request", () => {
        cy.request({
            method: "PATCH",
            url: "http://127.0.0.1:8000/api/products/8",
            body: {
                category_id: 1,
                product_name: "Data Update",
                product_stock: 200,
                product_price: 25000,
            },
        })
            .its("status")
            .should("equal", 200);
    });
    // DELETE Product Request
    it("DELETE Request", () => {
        cy.request("DELETE", "http://127.0.0.1:8000/api/products/9")
            .its("status")
            .should("equal", 200);
    });
});
