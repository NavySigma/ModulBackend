const BASE = "http://127.0.0.1:8000/api";

describe("Product Category HTTP Request", () => {
    let token;
    let categoryId;

    before(() => {
        // Login dan ambil JWT token
        cy.request("POST", `${BASE}/auth/login`, {
            email: "test@example.com",
            password: "password",
        }).then((res) => {
            token = res.body.accesstoken;

            // Buat category sebagai data seed untuk GET by ID, PATCH, DELETE
            cy.request({
                method: "POST",
                url: `${BASE}/product-categories`,
                headers: { Authorization: `Bearer ${token}` },
                body: {
                    category_name: "Seed Category",
                    category_desc: "Category created by Cypress",
                },
            }).then((catRes) => {
                categoryId = catRes.body.data.category_id;
            });
        });
    });

    // GET All Product Categories
    it("GET Request", () => {
        cy.request({
            method: "GET",
            url: `${BASE}/product-categories`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });

    // GET Product Category By ID
    it("GET By ID Request", () => {
        cy.request({
            method: "GET",
            url: `${BASE}/product-categories/${categoryId}`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });

    // POST Product Category
    it("POST Request", () => {
        cy.request({
            method: "POST",
            url: `${BASE}/product-categories`,
            headers: { Authorization: `Bearer ${token}` },
            body: {
                category_name: "Minuman",
                category_desc: "Kategori untuk produk minuman",
            },
        })
            .its("status")
            .should("equal", 201);
    });

    // PATCH Product Category
    it("PATCH Request", () => {
        cy.request({
            method: "PATCH",
            url: `${BASE}/product-categories/${categoryId}`,
            headers: { Authorization: `Bearer ${token}` },
            body: {
                category_name: "Category Updated",
                category_desc: "Deskripsi setelah diupdate",
            },
        })
            .its("status")
            .should("equal", 200);
    });

    // DELETE Product Category
    it("DELETE Request", () => {
        cy.request({
            method: "DELETE",
            url: `${BASE}/product-categories/${categoryId}`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });
});

describe("Product HTTP Request", () => {
    let token;
    let categoryId;
    let productId;

    before(() => {
        // Login dan ambil JWT token
        cy.request("POST", `${BASE}/auth/login`, {
            email: "test@example.com",
            password: "password",
        }).then((res) => {
            token = res.body.accesstoken;

            // Buat category agar category_id valid
            cy.request({
                method: "POST",
                url: `${BASE}/product-categories`,
                headers: { Authorization: `Bearer ${token}` },
                body: {
                    category_name: "Test Category",
                    category_desc: "Category created by Cypress",
                },
            }).then((catRes) => {
                categoryId = catRes.body.data.category_id;

                // Buat product sebagai data seed untuk GET by ID, PATCH, DELETE
                cy.request({
                    method: "POST",
                    url: `${BASE}/products`,
                    headers: { Authorization: `Bearer ${token}` },
                    body: {
                        category_id: categoryId,
                        product_name: "Seed Product",
                        product_stock: 100,
                        product_price: 10000,
                    },
                }).then((prodRes) => {
                    productId = prodRes.body.data.product_id;
                });
            });
        });
    });

    // GET All Products
    it("GET Request", () => {
        cy.request({
            method: "GET",
            url: `${BASE}/products`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });

    // GET Product By ID
    it("GET By ID Request", () => {
        cy.request({
            method: "GET",
            url: `${BASE}/products/${productId}`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });

    // POST Product
    it("POST Request", () => {
        cy.request({
            method: "POST",
            url: `${BASE}/products`,
            headers: { Authorization: `Bearer ${token}` },
            body: {
                category_id: categoryId,
                product_name: "Frisian Flag",
                product_stock: 200,
                product_price: 25000,
            },
        })
            .its("status")
            .should("equal", 201);
    });

    // PATCH Product
    it("PATCH Request", () => {
        cy.request({
            method: "PATCH",
            url: `${BASE}/products/${productId}`,
            headers: { Authorization: `Bearer ${token}` },
            body: {
                category_id: categoryId,
                product_name: "Data Update",
                product_stock: 200,
                product_price: 25000,
            },
        })
            .its("status")
            .should("equal", 200);
    });

    // DELETE Product
    it("DELETE Request", () => {
        cy.request({
            method: "DELETE",
            url: `${BASE}/products/${productId}`,
            headers: { Authorization: `Bearer ${token}` },
        })
            .its("status")
            .should("equal", 200);
    });
});
