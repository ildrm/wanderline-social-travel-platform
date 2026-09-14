import { cleanup, render, screen, waitFor } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { afterEach, beforeEach, describe, expect, it, vi } from "vitest";
import { AuthForm } from "./auth-form";

const push = vi.fn();
const refresh = vi.fn();

vi.mock("next/navigation", () => ({ useRouter: () => ({ push, refresh }) }));

afterEach(cleanup);

beforeEach(() => {
  push.mockReset();
  refresh.mockReset();
  vi.restoreAllMocks();
  document.cookie = "XSRF-TOKEN=test-token; path=/";
});

describe("AuthForm", () => {
  it("initializes CSRF and submits registration without storing a browser token", async () => {
    const fetchMock = vi.spyOn(globalThis, "fetch")
      .mockResolvedValueOnce(new Response(null, { status: 204 }))
      .mockResolvedValueOnce(new Response(JSON.stringify({ data: { id: "01TEST" } }), { status: 201, headers: { "Content-Type": "application/json" } }));
    const user = userEvent.setup();

    render(<AuthForm mode="register" returnTo="/journeys/grand-european-loop" />);
    await user.type(screen.getByLabelText("Name"), "Elena Rossi");
    await user.type(screen.getByLabelText("Email"), "elena@example.test");
    await user.type(screen.getByLabelText("Password", { exact: true }), "Correct-Horse-Battery1!");
    await user.type(screen.getByLabelText("Confirm password"), "Correct-Horse-Battery1!");
    await user.click(screen.getByRole("button", { name: "Create account" }));

    await waitFor(() => expect(push).toHaveBeenCalledWith("/journeys/grand-european-loop"));
    expect(fetchMock).toHaveBeenCalledTimes(2);
    expect(fetchMock.mock.calls[1]?.[1]).toMatchObject({
      method: "POST",
      credentials: "include",
      headers: expect.objectContaining({ "X-XSRF-TOKEN": "test-token" }),
    });
  });

  it("renders field-safe validation feedback", async () => {
    vi.spyOn(globalThis, "fetch")
      .mockResolvedValueOnce(new Response(null, { status: 204 }))
      .mockResolvedValueOnce(new Response(JSON.stringify({ message: "Please check the highlighted fields.", errors: { email: ["The email has already been taken."] } }), { status: 422, headers: { "Content-Type": "application/json" } }));
    const user = userEvent.setup();

    render(<AuthForm mode="register" />);
    await user.type(screen.getByLabelText("Name"), "Elena Rossi");
    await user.type(screen.getByLabelText("Email"), "elena@example.test");
    await user.type(screen.getByLabelText("Password", { exact: true }), "Correct-Horse-Battery1!");
    await user.type(screen.getByLabelText("Confirm password"), "Correct-Horse-Battery1!");
    await user.click(screen.getByRole("button", { name: "Create account" }));

    expect(await screen.findByText("The email has already been taken.")).toBeVisible();
    expect(screen.getByRole("alert")).toHaveTextContent("Please check the highlighted fields.");
    expect(push).not.toHaveBeenCalled();
  });
});
