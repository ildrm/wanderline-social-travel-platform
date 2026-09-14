import { cleanup, render, screen, waitFor } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { afterEach, beforeEach, describe, expect, it, vi } from "vitest";
import { QuickCreateForm } from "./quick-create-form";

afterEach(cleanup);

beforeEach(() => {
  vi.restoreAllMocks();
  document.cookie = "XSRF-TOKEN=create-token; path=/";
});

describe("QuickCreateForm", () => {
  it("creates a private draft through the authenticated API contract", async () => {
    const fetchMock = vi.spyOn(globalThis, "fetch")
      .mockResolvedValueOnce(new Response(null, { status: 204 }))
      .mockResolvedValueOnce(new Response(JSON.stringify({ data: { id: "01JOURNEY", title: "Cappadocia Together", status: "DRAFT", visibility: "PRIVATE" } }), { status: 201, headers: { "Content-Type": "application/json" } }));
    const user = userEvent.setup();

    render(<QuickCreateForm />);
    await user.type(screen.getByLabelText("Journey title"), "Cappadocia Together");
    await user.click(screen.getByRole("button", { name: "Create private draft" }));

    expect(await screen.findByText("Draft created")).toBeVisible();
    expect(screen.getByText("Cappadocia Together")).toBeVisible();
    const request = fetchMock.mock.calls[1];
    expect(request?.[0]).toBe("http://localhost:8000/api/v1/journeys");
    expect(request?.[1]).toMatchObject({ method: "POST", credentials: "include" });
    expect(JSON.parse(String(request?.[1]?.body))).toMatchObject({
      title: "Cappadocia Together",
      mode: "SOCIAL",
      capacity: 8,
      visibility: "PRIVATE",
    });
  });

  it("offers sign-in recovery for an unauthenticated create", async () => {
    vi.spyOn(globalThis, "fetch")
      .mockResolvedValueOnce(new Response(null, { status: 204 }))
      .mockResolvedValueOnce(new Response(JSON.stringify({ detail: "Valid authentication credentials are required." }), { status: 401, headers: { "Content-Type": "application/problem+json" } }));
    const user = userEvent.setup();

    render(<QuickCreateForm />);
    await user.type(screen.getByLabelText("Journey title"), "Cappadocia Together");
    await user.click(screen.getByRole("button", { name: "Create private draft" }));

    await waitFor(() => expect(screen.getByRole("alert")).toHaveTextContent("Sign in before creating a journey."));
    expect(screen.getByRole("link", { name: "Sign in" })).toHaveAttribute("href", "/login?returnTo=/journeys/new");
  });
});
